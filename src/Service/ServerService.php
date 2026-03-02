<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Server;
use App\Repository\ServerRepository;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;

readonly class ServerService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ServerRepository $serverRepository,
    ) {}

    /**
     * Set up the server by creating a new server entity and saving it to the database.
     * This method should only be called once in the applications lifetime, as it creates a new unique global server ID.
     * The global server ID should never be changed after it has been created, as it is used to identify the server against other servers.
     *
     * @return Server
     *
     * @throws LogicException if a server already exists in the database
     */
    public function setup(): Server
    {
        if ($this->serverRepository->count() > 0) {
            throw new LogicException('Server setup failed because a server already exists in the database');
        }

        $server = new Server()->setGlobalId(uniqid('s'));

        $this->entityManager->persist($server);
        $this->entityManager->flush();

        return $server;
    }
}
