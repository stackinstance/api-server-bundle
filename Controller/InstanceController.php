<?php

namespace StackInstance\ApiServerBundle\Controller;
use StackInstance\ApiServerBundle\Entity\Instance;

/**
 * InstanceController
 */
class InstanceController extends AbstractApiController
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listAction()
    {
        $instances = $this->getDoctrine()->getRepository('StackInstanceApiServerBundle:Instance')->findAll();

        $data = [];
        /** @var Instance $instance */
        foreach($instances as $instance) {
            $data[] = [$instance->getId() => $instance->getTitle()];
        }

        $responseData = ['data' => $data];
        return $this->successResponse($responseData);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction()
    {
        $responseData = ['data' => 'test'];
        return $this->successResponse($responseData);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction()
    {
        $responseData = ['data' => 'test'];
        return $this->successResponse($responseData);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction()
    {
        $responseData = ['data' => 'test'];
        return $this->successResponse($responseData);
    }
}
