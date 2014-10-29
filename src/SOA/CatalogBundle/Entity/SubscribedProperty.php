<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\Manager\Mapping\Annotation as MM;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use SOA\CatalogBundle\Model\SubscribedProperty as BaseSubscribedProperty;

/**
 * @ORM\Table(name="subscribed_property")
 * @ORM\Entity
 * @INTL\TranslatableEntity(translationClass="SubscribedPropertyTranslation")
 * @MM\ModelManager(class="Doctrine\Manager\Model\ORM\EntityManager")
 */
class SubscribedProperty extends BaseSubscribedProperty
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="subscribedProperties")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id", nullable=false)
     * @JMS\Groups({"api"})
     * @JMS\Inline
     */
    protected $property;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position = 0;

    /**
     * @JMS\Groups({"api"})
     * @JMS\Accessor(getter="getTranslation")
     * @JMS\Inline
     */
    protected $translation;
}