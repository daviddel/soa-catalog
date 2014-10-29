<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use SOA\CatalogBundle\Model\PropertyTranslation as BasePropertyTranslation;

/**
 * @ORM\Table(name="property_translation")
 * @ORM\Entity
 * @INTL\TranslationEntity(translatableClass="Property")
 */
class PropertyTranslation extends BasePropertyTranslation
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
}