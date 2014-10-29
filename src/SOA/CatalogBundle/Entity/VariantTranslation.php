<?php

namespace SOA\CatalogBundle\Entity;

use Doctrine\Intl\Mapping\Annotation as INTL;
use Doctrine\ORM\Mapping as ORM;
use SOA\CatalogBundle\Model\VariantTranslation as BaseVariantTranslation;

/**
 * @ORM\Table(name="variant_translation")
 * @ORM\Entity
 * @INTL\TranslationEntity(translatableClass="Variant")
 */
class VariantTranslation extends BaseVariantTranslation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}