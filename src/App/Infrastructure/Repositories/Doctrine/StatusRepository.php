<?php

namespace App\Infrastructure\Repositories\Doctrine;

use App\Domain\Entity\Status;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\StatusRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Status|null find($id, $lockMode = null, $lockVersion = null)
 * @method Status|null findOneBy(array $criteria, array $orderBy = null)
 * @method Status[]    findAll()
 * @method Status[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusRepository extends ServiceEntityRepository implements StatusRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }

    public function listAll()
    {
        $qb = $this->createQueryBuilder('status');

        return $qb->select('status')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
