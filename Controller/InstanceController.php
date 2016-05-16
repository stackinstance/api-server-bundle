<?php

namespace StackInstance\ApiServerBundle\Controller;
use Doctrine\DBAL\DBALException;
use StackInstance\ApiServerBundle\Entity\Instance;
use Symfony\Component\HttpFoundation\Request;

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
        if ($this->isAuthorized() !== true) {
            return $this->errorResponse(401, 'Unauthorized');
        }

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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(Request $request)
    {
        if ($this->isAuthorized() !== true) {
            return $this->errorResponse(401, 'Unauthorized');
        }

        if ($this->isValidAddCall($request) === false) {
            return $this->errorResponse(401, 'No title provided');
        }

        /** @var Instance $instance */
        $instance = $this->createInstance($request);

        if ($instance === false) {
            return $this->errorResponse(401, 'Could not create instance');
        }

        $response = ['id' => $instance->getId(),
                     'title' => $instance->getTitle()
        ];

        $responseData = ['data' => $response];
        return $this->successResponse($responseData);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction()
    {
        if ($this->isAuthorized() !== true) {
            return $this->errorResponse(401, 'Unauthorized');
        }

        $responseData = ['data' => 'test'];
        return $this->successResponse($responseData);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction()
    {
        if ($this->isAuthorized() !== true) {
            return $this->errorResponse(401, 'Unauthorized');
        }

        $responseData = ['data' => 'test'];
        return $this->successResponse($responseData);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function isValidAddCall(Request $request)
    {
        $title = $request->get('title');
        if ($title ===  null) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @return bool|Instance
     */
    protected function createInstance(Request $request)
    {
        $title = $request->get('title');

        $instance = new Instance();
        $instance->setTitle($title);

        $entityManager = $this->getDoctrine()->getManager();
        try {
            $entityManager->persist($instance);
            $entityManager->flush();
        } catch (DBALException $e) {
            return false;
        }
        return $instance;
    }
}
