<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\TranslatableInterface;

interface PropertyInterface extends TranslatableInterface
{
    function getKey();
} 