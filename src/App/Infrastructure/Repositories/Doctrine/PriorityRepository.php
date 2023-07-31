<?php

namespace App\Infrastructure\Repositories\Doctrine;

use App\Domain\Entity\Priority;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\PriorityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Priority|null find($id, $lockMode = null, $lockVersion = null)
 * @method Priority|null findOneBy(array $criteria, array $orderBy = null)
 * @method Priority[]    findAll()
 * @method Priority[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriorityRepository extends ServiceEntityRepository implements PriorityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Priority::class);
    }

    public function listAll()
    {
        return $this->createQueryBuilder('priority')
            ->select('priority')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
