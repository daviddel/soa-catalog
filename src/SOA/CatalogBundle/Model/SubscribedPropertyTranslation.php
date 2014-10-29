<?php

namespace SOA\CatalogBundle\Model;

use Doctrine\Intl\Model\Translation;

class SubscribedPropertyTranslation implements  SubscribedPropertyTranslationInterface
{
    use Translation;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return SubscribedPropertyTranslationInterface
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }


} 