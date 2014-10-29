<?php

namespace SOA\CatalogBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Knp\Component\Pager\Pagination\PaginationInterface;

class ObjectList
{
    /**
     * @var PaginationInterface
     */
    protected $list;

    /**
     * @return PaginationInterface
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param $list
     * @return ObjectList
     */
    public function setList($list)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * @return PaginationInterface
     *
     * @JMS\VirtualProperty
     * @JMS\XmlList(entry="item")
     * @JMS\Groups({"api"})
     */
    public function getItems()
    {
        if ($this->list instanceof PaginationInterface)
            return $this->list->getItems();

        return $this->list;
    }

    /**
     * @return int|null
     *
     * @JMS\VirtualProperty
     * @JMS\Type("integer")
     * @JMS\Groups({"api"})
     */
    public function getCurrentPageNumber()
    {
        if ($this->list instanceof PaginationInterface)
            return $this->list->getCurrentPageNumber();

        return null;
    }

    /**
     * @return int|null
     *
     * @JMS\VirtualProperty
     * @JMS\Type("integer")
     * @JMS\Groups({"api"})
     */
    public function getItemNumberPerPage()
    {
        if ($this->list instanceof PaginationInterface)
            return $this->list->getItemNumberPerPage();

        return null;
    }

    /**
     * @return int
     *
     * @JMS\VirtualProperty
     * @JMS\Type("integer")
     * @JMS\Groups({"api"})
     */
    public function getTotalItemCount()
    {
        if ($this->list instanceof PaginationInterface)
            return $this->list->getTotalItemCount();

        return count($this->list);
    }
}