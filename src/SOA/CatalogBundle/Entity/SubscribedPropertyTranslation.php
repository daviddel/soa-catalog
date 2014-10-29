<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use SOA\CatalogBundle\Model\SubscribedPropertyTranslation as BaseSubscribedPropertyTranslation;

/**
 * @ORM\Table(name="subscribed_property_translation")
 * @ORM\Entity
 * @INTL\TranslationEntity(translatableClass="SubscribedProperty")
 */
class SubscribedPropertyTranslation extends BaseSubscribedPropertyTranslation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     * @JMS\Groups({"api"})
     */
    protected $value;
}