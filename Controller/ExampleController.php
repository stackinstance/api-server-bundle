<?php

namespace StackInstance\ApiServerBundle\Controller;

/**
 * ExampleController
 */
class ExampleController extends AbstractApiController
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction()
    {
        $data = ['data' => 'test'];
        return $this->successResponse($data);
    }
}
