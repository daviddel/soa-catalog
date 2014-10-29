<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\Translation;

class PropertyTranslation implements PropertyTranslationInterface
{
    use Translation;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PropertyTranslationInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
} 