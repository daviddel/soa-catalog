<?php

namespace SOA\CatalogBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ObjectToPropertyTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $objectClass;
    private $property;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $objectClass, $property)
    {
        $this->om = $om;
        $this->objectClass = $objectClass;
        $this->property = $property;
    }

    /**
     * @param mixed $object
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     *
     * @return mixed
     */
    public function transform($object)
    {
        if (null === $object || !$object instanceof $this->objectClass) {
            return null;
        }

        if (!property_exists($object, $this->property)) {
            return null;
        }

        $getter = 'get'.ucfirst($this->property);
        return $object->$getter();
    }

    /**
     * @param mixed $id
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     *
     * @return mixed|object
     */
    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }

        $object = $this->om->getRepository($this->objectClass)->findOneBy(array($this->property => $value));

        if (null === $object) {
            throw new TransformationFailedException(sprintf(
                'A %s with "%s" "%s" does not exist!',
                $this->objectClass,
                $this->property,
                $value
            ));
        }

        return $object;
    }
} 