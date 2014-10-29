<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\Manager\Mapping\Annotation as MM;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use SOA\CatalogBundle\Model\Property as BaseProperty;

/**
 * @ORM\Table(name="property")
 * @ORM\Entity
 * @INTL\TranslatableEntity(translationClass="PropertyTranslation")
 * @MM\ModelManager(class="Doctrine\Manager\Model\ORM\EntityManager")
 */
class Property extends BaseProperty
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="key_value", type="string")
     * @JMS\Groups({"api"})
     * @JMS\XmlAttribute
     */
    protected $key;

    /**
     * @JMS\Groups({"api"})
     * @JMS\Accessor(getter="getTranslation")
     * @JMS\Inline
     */
    protected $translation;
}