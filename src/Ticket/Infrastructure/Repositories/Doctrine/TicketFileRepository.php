<?php

namespace Ticket\Infrastructure\Repositories\Doctrine;

use Ticket\Domain\Entity\TicketFile;
use Doctrine\Persistence\ManagerRegistry;
use Ticket\Domain\Repository\TicketFileRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TicketFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketFile[]    findAll()
 * @method TicketFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketFileRepository extends ServiceEntityRepository implements TicketFileRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketFile::class);
    }
}
