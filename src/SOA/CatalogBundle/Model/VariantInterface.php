<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\TranslatableInterface;

interface VariantInterface extends TranslatableInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     * @return mixed
     */
    function setId($id);

    /**
     * @return ProductInterface
     */
    function getProduct();

    /**
     * @param ProductInterface|null $product
     * @return mixed
     */
    function setProduct($product = null);
} 