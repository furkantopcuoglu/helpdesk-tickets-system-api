<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Priority;

/**
 * @method Priority|null find($id, $lockMode = null, $lockVersion = null)
 * @method Priority|null findOneBy(array $criteria, array $orderBy = null)
 * @method Priority[]    findAll()
 * @method Priority[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface PriorityRepositoryInterface
{
    public function listAll();
}
