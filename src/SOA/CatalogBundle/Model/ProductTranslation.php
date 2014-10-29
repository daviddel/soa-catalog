<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\Translation;

class ProductTranslation implements ProductTranslationInterface
{
    use Translation;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ProductTranslationInterface
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ProductTranslationInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}