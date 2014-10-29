<?php

namespace SOA\CatalogBundle\Entity\Manager;

use Doctrine\Manager\Model\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class ProductManager extends EntityManager
{
    /**
     * @param array $criteria
     * @param array $sort
     * @param int $page
     * @param int $limit
     * @param QueryBuilder $queryBuilder
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function paginateBy(array $criteria = array(), array $sort = array(), $page = 1, $limit = 25, QueryBuilder $queryBuilder = null)
    {
        if (!isset($queryBuilder)) {
            $queryBuilder = $this->getRepository()->getQueryBuilder($criteria, $sort);
        }

        $paginator  = $this->container->get('knp_paginator');
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $page,
            $limit
        );

        return $pagination;
    }
} 