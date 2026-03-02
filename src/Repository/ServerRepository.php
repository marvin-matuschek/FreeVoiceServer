<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Server;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;

/**
 * @extends ServiceEntityRepository<Server>
 */
class ServerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Server::class);
    }

    /**
     * @return Server
     * @throws LogicException if no server is found in the database
     */
    public function findLocalServer(): Server
    {
        $server = $this
            ->createQueryBuilder('s')
            ->setMaxResults(1)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();

        return $server instanceof Server ? $server : throw new LogicException('No server found. Please set up this server first.');
    }
}
