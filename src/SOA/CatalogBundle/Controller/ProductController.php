<?php

namespace SOA\CatalogBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
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
     * @Cache(smaxage=21600, expires="+6 hours")
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
     *
     * @param Request $request
     * @param string $reference
     * @return array|\FOS\RestBundle\View\View
     */
    public function postEditAction(Request $request, $reference)
    {
        $product = $this->getProductByReference($reference);

        return $this->post($request, $product);
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/create")
     *
     * @param Request $request
     * @return array|\FOS\RestBundle\View\View
     */
    public function postCreateAction(Request $request)
    {
        /** @var \SOA\CatalogBundle\Model\ProductInterface $product */
        $product = $this->getProductManager()->create();

        return $this->post($request, $product);
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @Cache(smaxage=21600, expires="+6 hours")
     *
     * @param string $reference
     * @return ProductInterface
     */
    public function getAction($reference)
    {
        return $this->getProductByReference($reference);
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/{reference}/variants/add")
     *
     * @param Request $request
     * @param string $reference
     * @return array|\FOS\RestBundle\View\View
     */
    public function postProductVariantsAction(Request $request, $reference)
    {
        $product = $this->getProductByReference($reference);

        /** @var \SOA\CatalogBundle\Model\VariantInterface $variant */
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
     *
     * @param string $reference
     */
    public function deleteProductVariantsAction($reference)
    {

    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @Cache(smaxage=21600, expires="+6 hours")
     *
     * @param string $reference
     * @return mixed
     */
    public function getVariantsAction($reference)
    {
        $product = $this->getProductByReference($reference);

        return $product->getVariants();
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/products/{reference}/properties/add")
     *
     * @param Request $request
     * @param string $reference
     * @return array|\FOS\RestBundle\View\View
     */
    public function postProductPropertiesAction(Request $request, $reference)
    {
        $product = $this->getProductByReference($reference);

        /** @var \SOA\CatalogBundle\Model\SubscribedPropertyInterface $subscribedProperty */
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
     *
     * @param string $reference
     * @param string $key
     */
    public function deleteProductPropertiesAction($reference, $key)
    {

    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @Cache(smaxage=21600, expires="+6 hours")
     *
     * @param string $reference
     * @return mixed
     */
    public function getPropertiesAction($reference)
    {
        $product = $this->getProductByReference($reference);

        return $product->getSubscribedProperties();
    }

    /**
     * @param Request $request
     * @param ProductInterface $product
     * @return array|\FOS\RestBundle\View\View
     */
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

    /**
     * @param $reference
     * @throws NotFoundHttpException
     * @return ProductInterface
     */
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
        return $this->get('manager.factory')->getManager('\SOA\CatalogBundle\Entity\Product');
    }

    /**
     * @return \Doctrine\Manager\Model\ModelManagerInterface
     */
    private function getVariantManager()
    {
        return $this->get('manager.factory')->getManager('\SOA\CatalogBundle\Entity\Variant');
    }

    /**
     * @return \Doctrine\Manager\Model\ModelManagerInterface
     */
    private function getSubscribedPropertyManager()
    {
        return $this->get('manager.factory')->getManager('\SOA\CatalogBundle\Entity\SubscribedProperty');
    }
}