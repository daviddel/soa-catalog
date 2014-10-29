<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\Manager\Mapping\Annotation as MM;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use SOA\CatalogBundle\Model\Product as BaseProduct;

/**
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="SOA\CatalogBundle\Entity\Repository\ProductRepository")
 * @INTL\TranslatableEntity(translationClass="ProductTranslation")
 * @MM\ModelManager(class="SOA\CatalogBundle\Entity\Manager\ProductManager")
 */
class Product extends BaseProduct
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @JMS\XmlAttribute
     * @JMS\Groups({"api"})
     */
    protected $reference;

    /**
     * @ORM\OneToMany(targetEntity="Variant", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     */
    protected $variants;

    /**
     * @ORM\OneToMany(targetEntity="SubscribedProperty", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy(value={"position": "ASC"})
     * @JMS\Groups({"api"})
     * @JMS\XmlList(entry="property")
     * @JMS\SerializedName("properties")
     */
    protected $subscribedProperties;

    /**
     * @JMS\Groups({"api"})
     * @JMS\Accessor(getter="getTranslation")
     * @JMS\Inline
     */
    protected $translation;
}