<?php

namespace SOA\CatalogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ProductRepository extends EntityRepository
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return \Doctrine\ORM\Query
     */
    public function getQuery(array $criteria = array(), array $orderBy = array(), $limit = null, $offset = null)
    {
        return $this->getQueryBuilder($criteria, $orderBy, $limit, $offset)->getQuery();
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder(array $criteria = array(), array $orderBy = array(), $limit = null, $offset = null)
    {
        $this->alias = strtolower(substr(basename($this->_class), 0, 1));
        $qb = $this->createQueryBuilder($this->alias);
        $this->buildCriteria($criteria, $qb);
        $this->buildSort($orderBy, $qb);
        if (is_int($limit))
            $qb->setMaxResults($limit);
        if (is_int($offset))
            $qb->setFirstResult($offset);

        return $qb;
    }

    /**
     * @param array $criteria
     * @param QueryBuilder $qb
     */
    public function buildCriteria(array $criteria, QueryBuilder $qb)
    {
        foreach ($criteria as $key => $value)
        {
            if (!(strpos($key, '.') !== false))
                $key = $this->alias.'.'.$key;
            $param = str_replace('.', '_', $key);

            if ($value === null)
                $qb->andWhere($qb->expr()->isNull($key));
            else
            {
                if (is_array($value))
                    $qb->andWhere($qb->expr()->in($key, ':'.$param));
                else
                    $qb->andWhere($qb->expr()->eq($key, ':'.$param));
                if (is_object($value))
                    $qb->setParameter($param, $value->getId());
                else
                    $qb->setParameter($param, $value);
            }
        }
    }

    /**
     * @param array $orderBy
     * @param QueryBuilder $qb
     */
    public function buildSort(array $orderBy, QueryBuilder $qb)
    {
        foreach ($orderBy as $sortField => $sortDirection)
            $qb->addOrderBy($this->alias.'.'.$sortField, $sortDirection);
    }
} 