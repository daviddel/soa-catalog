<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use SOA\CatalogBundle\Model\ProductTranslation as BaseProductTranslation;

/**
 * @ORM\Table(name="product_translation")
 * @ORM\Entity
 * @INTL\TranslationEntity(translatableClass="Product")
 */
class ProductTranslation extends BaseProductTranslation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @JMS\Groups({"api"})
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     * @JMS\Groups({"api"})
     */
    protected $description;
}