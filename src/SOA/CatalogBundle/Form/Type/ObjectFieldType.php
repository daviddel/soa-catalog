<?php

namespace SOA\CatalogBundle\Form\Type;

use Doctrine\Common\Persistence\ManagerRegistry;
use SOA\CatalogBundle\Form\DataTransformer\ObjectToPropertyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectFieldType extends AbstractType
{
    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ObjectToPropertyTransformer($options['om'], $options['class'], $options['property']));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $registry = $this->registry;

        $omNormalizer = function (Options $options, $om) use ($registry) {
            /* @var ManagerRegistry $registry */
            if (null !== $om) {
                return $registry->getManager($om);
            }

            $om = $registry->getManagerForClass($options['class']);

            if (null === $om) {
                throw new RuntimeException(sprintf(
                    'Class "%s" seems not to be a managed Doctrine entity. '.
                    'Did you forget to map it?',
                    $options['class']
                ));
            }

            return $om;
        };

        $resolver->setDefaults(array(
            'om'            => null,
            'property'      => 'id'
        ));

        $resolver->setRequired(array('class'));

        $resolver->setNormalizers(array(
            'om' => $omNormalizer,
        ));
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'object_field';
    }
} 