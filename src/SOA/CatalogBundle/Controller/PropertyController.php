<?php

namespace SOA\CatalogBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use FOS\RestBundle\Controller\FOSRestController;
use SOA\CatalogBundle\Model\ObjectList;
use SOA\CatalogBundle\Model\PropertyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @REST\RouteResource("Property")
 */
class PropertyController extends FOSRestController
{
    /**
     * @REST\View(serializerGroups={"api"})
     *
     * @param Request $request
     * @return ObjectList
     */
    public function cgetAction(Request $request)
    {
        $properties = $this->getPropertyManager()->paginateBy(
            array(),
            array(),
            $request->get('page', 1),
            $request->get('nb', 25)
        );

        $list = new ObjectList();
        $list->setList($properties);

        return $list;
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/properties/edit/{reference}")
     *
     * @param Request $request
     * @param string $key
     * @return array|\FOS\RestBundle\View\View
     */
    public function postEditAction(Request $request, $key)
    {
        $property = $this->getPropertyByKey($key);

        return $this->post($request, $property);
    }

    /**
     * @REST\View(serializerGroups={"api"})
     * @REST\Route("/properties/create")
     *
     * @param Request $request
     * @return array|\FOS\RestBundle\View\View
     */
    public function postCreateAction(Request $request)
    {
        /** @var \SOA\CatalogBundle\Model\PropertyInterface $property */
        $property = $this->getPropertyManager()->create();

        return $this->post($request, $property);
    }

    /**
     * @REST\View(serializerGroups={"api"})
     *
     * @param string $key
     * @return mixed
     */
    public function getAction($key)
    {
        return $this->getPropertyByKey($key);
    }

    /**
     * @param Request $request
     * @param PropertyInterface $property
     * @return array|\FOS\RestBundle\View\View
     */
    protected function post(Request $request, PropertyInterface $property)
    {
        $form = $this->createForm('property', $property);

        if ($form->handleRequest($request)->isValid()) {
            $this->getPropertyManager()->save($property);

            return $this->routeRedirectView('soa_catalog_property_get_property', array(
                    'key'       => $property->getKey(),
                    '_format'   => $request->getRequestFormat()
                )
            );
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * @param string $key
     * @throws NotFoundHttpException
     * @return PropertyInterface
     */
    protected function getPropertyByKey($key)
    {
        $property = $this->getPropertyManager()->findOneBy(array('key' => $key));

        if (!$property) {
            throw new NotFoundHttpException();
        }

        return $property;
    }

    /**
     * @return \Doctrine\Manager\Model\ModelManagerInterface
     */
    private function getPropertyManager()
    {
        return $this->get('manager.factory')->getManager('\\SOA\\CatalogBundle\\Entity\\Property');
    }
}