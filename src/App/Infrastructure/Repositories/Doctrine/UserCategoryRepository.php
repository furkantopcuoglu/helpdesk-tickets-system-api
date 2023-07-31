<?php

namespace App\Infrastructure\Repositories\Doctrine;

use App\Domain\Entity\UserCategory;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\UserCategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method UserCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCategory[]    findAll()
 * @method UserCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCategoryRepository extends ServiceEntityRepository implements UserCategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCategory::class);
    }
}
