<?php

namespace SOA\CatalogBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use SOA\CatalogBundle\Model\ObjectList;
use SOA\CatalogBundle\Model\ProductInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @REST\RouteResource("Product")
 */
class ProductController extends FOSRestController
{
    /**
     * @REST\View(serializerGroups={"api"})
     */
    public function cgetAction(Request $request)
    {
        $products = $this->getProductManager()->paginateBy(
            array(),
            array(),
            $request->get('page', 1),
            $request->get('nb', 25)
        );

        $list = new ObjectList();
        $list->setList($products);

        return $list;
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/edit/{reference}")
     */
    public function postEditAction(Request $request, $reference)
    {
        $product = $this->getProductByReference($reference);

        return $this->post($request, $product);
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/create")
     */
    public function postCreateAction(Request $request)
    {
        $product = $this->getProductManager()->create();

        return $this->post($request, $product);
    }

    public function newAction()
    {
        $product = $this->getProductManager()->create();
        $product->setReference(uniqid())
            ->setName('Product with name #'.$product->getReference())
            ->setDescription('Product with description #'.$product->getReference());

        for ($i = 0; $i < 4; $i++) {
            $variant = $this->getVariantManager()->create();
            $product->addVariant($variant);
        }

        for ($i = 0; $i < 4; $i++) {
            $property = $this->getPropertyManager()->findOneBy(array('key' => 'PROP'.$i));
            if ($property) {
                $subscribedProperty = $this->getSubscribedPropertyManager()->create();
                $subscribedProperty->setProperty($property)
                    ->setValue(uniqid());

                $product->addSubscribedProperty($subscribedProperty);
            }
        }

        $this->getProductManager()->save($product);

        return $product;
    }

    /**
     * @REST\View(serializerGroups={"api"})
     */
    public function getAction($reference)
    {
        return $this->getProductByReference($reference);
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/{reference}/variants/add")
     */
    public function postProductVariantsAction(Request $request, $reference)
    {
        $product = $this->getProductByReference($reference);
        $variant = $this->getVariantManager()->create();
        $product->addVariant($variant);

        $form = $this->createForm('variant', $variant);

        if ($form->handleRequest($request)->isValid()) {
            $this->getProductManager()->save($product);

            return $this->routeRedirectView('soa_catalog_product_get_product_variants', array(
                    'reference' => $product->getReference(),
                    '_format'   => $request->getRequestFormat()
                )
            );
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/{reference}/variants/remove")
     */
    public function deleteProductVariantsAction($reference)
    {

    }

    /**
     * @REST\View(serializerGroups={"api"})
     */
    public function getVariantsAction($reference)
    {
        $product = $this->getProductByReference($reference);

        return $product->getVariants();
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/{reference}/properties/add")
     */
    public function postProductPropertiesAction(Request $request, $reference)
    {
        $product = $this->getProductByReference($reference);

        $subscribedProperty = $this->getSubscribedPropertyManager()->create();
        $product->addSubscribedProperty($subscribedProperty);

        $form = $this->createForm('subscribed_property', $subscribedProperty);

        if ($form->handleRequest($request)->isValid()) {
            $this->getProductManager()->save($product);

            return $this->routeRedirectView('soa_catalog_product_get_product_properties', array(
                    'reference' => $product->getReference(),
                    '_format'   => $request->getRequestFormat()
                )
            );
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/{reference}/variants/remove")
     */
    public function deleteProductPropertiesAction($reference, $key)
    {

    }

    /**
     * @REST\View(serializerGroups={"api"})
     */
    public function getPropertiesAction($reference)
    {
        $product = $this->getProductByReference($reference);

        return $product->getSubscribedProperties();
    }

    protected function post(Request $request, ProductInterface $product)
    {
        $form = $this->createForm('product', $product);

        if ($form->handleRequest($request)->isValid()) {
            $this->getProductManager()->save($product);

            return $this->routeRedirectView('soa_catalog_product_get_product', array(
                    'reference' => $product->getReference(),
                    '_format'   => $request->getRequestFormat()
                )
            );
        }

        return array(
            'form' => $form,
        );
    }

    protected function getProductByReference($reference)
    {
        $product = $this->getProductManager()->findOneBy(array('reference' => $reference));

        if (!$product) {
            throw new NotFoundHttpException();
        }

        return $product;
    }

    /**
     * @return \Doctrine\Manager\Model\ModelManagerInterface
     */
    private function getProductManager()
    {
        return $this->get('manager.factory')->getManager('\\SOA\\CatalogBundle\\Entity\\Product');
    }

    /**
     * @return \Doctrine\Manager\Model\ModelManagerInterface
     */
    private function getVariantManager()
    {
        return $this->get('manager.factory')->getManager('\\SOA\\CatalogBundle\\Entity\\Variant');
    }

    /**
     * @return \Doctrine\Manager\Model\ModelManagerInterface
     */
    private function getSubscribedPropertyManager()
    {
        return $this->get('manager.factory')->getManager('\\SOA\\CatalogBundle\\Entity\\SubscribedProperty');
    }

    /**
     * @return \Doctrine\Manager\Model\ModelManagerInterface
     */
    private function getPropertyManager()
    {
        return $this->get('manager.factory')->getManager('\\SOA\\CatalogBundle\\Entity\\Property');
    }
}