<?php

namespace App\Infrastructure\Repositories\Doctrine;

use App\Domain\Entity\Category;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function listAll()
    {
        $qb = $this->createQueryBuilder('category');

        $qb->select('category')
            ->where($qb->expr()->eq('category.isDefault', ':isDefault'))
            ->setParameter('isDefault', true);

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
