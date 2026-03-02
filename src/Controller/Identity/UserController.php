<?php

declare(strict_types=1);

namespace App\Controller\Identity;

use App\Entity\Identity\User;
use App\Service\Identity\UserService;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    #[Route('/register', name: 'identity_register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $password = $request->request->get('password');
        $email = $request->request->get('email');
        $username = $request->request->get('username');

        if (!is_string($password) || !is_string($email) || !is_string($username)) {
            return new JsonResponse(['message' => 'Missing or invalid data provided.'], Response::HTTP_BAD_REQUEST);
        }

        $user = new User()->setEmail($email)->setUsername($username);
        try {
            $this->userService->registerUser($user, $password);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (RuntimeException) {
            return new Response(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['message' => 'User registered.'], Response::HTTP_CREATED);
    }
}
