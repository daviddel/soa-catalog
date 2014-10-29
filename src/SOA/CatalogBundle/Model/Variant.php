<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\Translatable;

class Variant implements VariantInterface
{
    use Translatable;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var ProductInterface
     */
    protected $product;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return VariantInterface
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param ProductInterface|null $product
     * @return VariantInterface
     */
    public function setProduct($product = null)
    {
        $this->product = $product;

        return $this;
    }
} 