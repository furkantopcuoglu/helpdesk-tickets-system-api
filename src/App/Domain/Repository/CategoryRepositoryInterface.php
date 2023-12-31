<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Category;
use App\Application\Queries\Category\List\ListCategoryQuery;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface CategoryRepositoryInterface
{
    public function listAll(ListCategoryQuery $query);
}
