<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\Manager\Mapping\Annotation as MM;
use Doctrine\ORM\Mapping as ORM;
use SOA\CatalogBundle\Model\Variant as BaseVariant;

/**
 * @ORM\Table(name="variant")
 * @ORM\Entity
 * @INTL\TranslatableEntity(translationClass="VariantTranslation")
 * @MM\ModelManager(class="Doctrine\Manager\Model\ORM\EntityManager")
 */
class Variant extends BaseVariant
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="variants")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;
}