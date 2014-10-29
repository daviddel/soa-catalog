<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\Translatable;

class SubscribedProperty implements SubscribedPropertyInterface
{
    use Translatable;

    /**
     * @var ProductTranslationInterface
     */
    protected $product;

    /**
     * @var PropertyTranslationInterface
     */
    protected $property;

    /**
     * @var int
     */
    protected $position;

    /**
     * @return ProductTranslationInterface
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param ProductTranslationInterface $product
     * @return SubscribedPropertyInterface
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return PropertyTranslationInterface
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param PropertyTranslationInterface $property
     * @return SubscribedPropertyInterface
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return int
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
} 