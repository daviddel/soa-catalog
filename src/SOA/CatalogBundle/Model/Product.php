<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Intl\Model\Translatable;

class Product implements ProductInterface
{
    use Translatable;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @return Collection
     */
    protected $variants;

    /**
     * @return Collection
     */
    protected $subscribedProperties;

    public function __construct()
    {
        $this->variants = new ArrayCollection();
        $this->subscribedProperties = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProductInterface
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return ProductInterface
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param VariantInterface $variant
     * @return ProductInterface
     */
    public function addVariant(VariantInterface $variant)
    {
        $this->variants->add($variant);
        $variant->setProduct($this);

        return $this;
    }

    /**
     * @param VariantInterface $variant
     * @return ProductInterface
     */
    public function removeVariant(VariantInterface $variant)
    {
        $this->variants->removeElement($variant);
        $variant->setProduct(null);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSubscribedProperties()
    {
        return $this->subscribedProperties;
    }

    /**
     * @param SubscribedPropertyInterface $subscribedProperty
     * @return ProductInterface
     */
    public function addSubscribedProperty(SubscribedPropertyInterface $subscribedProperty)
    {
        $this->subscribedProperties->add($subscribedProperty);
        $subscribedProperty->setProduct($this);

        return $this;
    }

    /**
     * @param SubscribedPropertyInterface $subscribedProperty
     * @return ProductInterface
     */
    public function removeSubscribedProperty(SubscribedPropertyInterface $subscribedProperty)
    {
        $this->variants->removeElement($subscribedProperty);
        $subscribedProperty->setProduct(null);

        return $this;
    }
} 