<?php

namespace StackInstance\ApiServerBundle\Controller;

use Doctrine\DBAL\DBALException;
use StackInstance\ApiServerBundle\Entity\Instance;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $isValidAddCall = $this->isValidAddCall($request);
        if ($isValidAddCall instanceof JsonResponse) {
            return $isValidAddCall;
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
     * @param Request $request
     * @param         $id
     * @return bool|JsonResponse
     */
    public function updateAction(Request $request, $id)
    {
        if ($this->isAuthorized() !== true) {
            return $this->errorResponse(401, 'Unauthorized');
        }

        $isValidUpdateCall = $this->isValidUpdateCall($request, $id);
        if ($isValidUpdateCall instanceof JsonResponse) {
            return $isValidUpdateCall;
        }

        /** @var Instance $instance */
        $instance = $this->updateInstance($request, $id);

        if ($instance === false) {
            return $this->errorResponse(401, 'Could not update instance');
        }

        $response = ['id' => $instance->getId(),
            'title' => $instance->getTitle()
        ];

        $responseData = ['data' => $response];
        return $this->successResponse($responseData);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        $deleted = $this->deleteInstance($id);
        if ($deleted === false) {
            return $this->errorResponse(401, 'Could not delete instance');
        }

        $response = ['deleted' => true];
        $responseData = ['data' => $response];
        return $this->successResponse($responseData);
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

    /**
     * @param Request $request
     * @return bool
     */
    protected function isValidAddCall(Request $request)
    {
        $title = $request->get('title');
        if ($title ===  null) {
            return $this->errorResponse(401, 'No title provided');
        }

        return true;
    }

    /**
     * @param Request $request
     * @param         $id
     * @return bool|\Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function isValidUpdateCall(Request $request, $id)
    {
        if ($id === null) {
            return $this->errorResponse(401, 'No instance id provided');
        }

        $title = $request->get('title');
        if ($title ===  null) {
            return $this->errorResponse(401, 'No title provided');
        }

        return true;
    }

    /**
     * @param Request $request
     * @param         $id
     * @return bool|null|object|Instance
     */
    protected function updateInstance(Request $request, $id)
    {
        $title = $request->get('title');

        $entityManager = $this->getDoctrine()->getManager();
        $instance = $entityManager->getRepository('StackInstanceApiServerBundle:Instance')->findOneBy(array('id' => $id));

        if ($instance === null) {
            return false;
        }

        $instance->setTitle($title);

        try {
            $entityManager->persist($instance);
            $entityManager->flush();
        } catch (DBALException $e) {
            return false;
        }
        return $instance;
    }

    /**
     * @param $id
     * @return bool
     */
    protected function deleteInstance($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $instance = $entityManager->getRepository('StackInstanceApiServerBundle:Instance')->findOneBy(array('id' => $id));

        if ($instance === null) {
            return false;
        }

        try {
            $entityManager->remove($instance);
            $entityManager->flush();
        } catch (DBALException $e) {
            return false;
        }
        return true;
    }

}
