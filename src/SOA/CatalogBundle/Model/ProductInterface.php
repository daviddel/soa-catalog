<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\TranslatableInterface;

interface ProductInterface extends TranslatableInterface
{
    function getReference();

    function getSubscribedProperties();

    function addSubscribedProperty(SubscribedPropertyInterface $subscribedProperty);

    function getVariants();

    function addVariant(VariantInterface $variant);
}