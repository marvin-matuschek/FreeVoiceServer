<?php

declare(strict_types=1);

namespace App\Service\Identity;

use App\Entity\Identity\User;
use App\Repository\Identity\UserRepository;
use App\Repository\ServerRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use LogicException;
use RuntimeException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserService
{
    public function __construct(
        private ServerRepository $serverRepository,
        private UserRepository $userRepository,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {}

    /**
     * @throws RuntimeException
     */
    public function generateUserGlobalId(): string
    {
        $serverGlobalID = $this->serverRepository->findLocalServer()->getGlobalId();

        if ($this->userRepository->count() >= 999999) {
            throw new RuntimeException('User global ID generation failed because the maximum number of users has been reached');
        }

        do {
            $globalUserID = "{$serverGlobalID}u" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
        } while ($this->userRepository->findOneBy(['globalId' => $globalUserID]) !== null);

        return $globalUserID;
    }

    /**
     * @throws RuntimeException
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function registerUser(User $user, string $rawPassword): User
    {
        $user->setGlobalId($this->generateUserGlobalId())
            ->setServer($this->serverRepository->findLocalServer())
            ->setPassword($this->passwordHasher->hashPassword($user, $rawPassword));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new InvalidArgumentException('User registration failed because the provided user data is invalid: ' . $errors);
        }

        $this->entityManager->persist($user);

        try {
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException) {
            throw new InvalidArgumentException('User registration failed because the provided email or username is already in use.');
        }

        return $user;
    }
}
