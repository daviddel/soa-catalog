<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\Translatable;

class Property implements PropertyInterface
{
    use Translatable;

    /**
     * @var string
     */
    protected $key;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return PropertyInterface
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }
} 