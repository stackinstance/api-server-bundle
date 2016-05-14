<?php

namespace StackInstance\ApiServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AbstractApiController
 */
abstract class AbstractApiController extends Controller
{
    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public function successResponse(array $data)
    {
        return new JsonResponse([
            'success' => true,
            'code' => 200,
            'data' => json_encode($data)
        ]);
    }

    /**
     * @param integer $code
     * @param string $message
     *
     * @return JsonResponse
     */
    public function errorResponse($code, $message)
    {
        $response = new JsonResponse([
            'success' => false,
            'code' => $code,
            'message' => $message,
        ]);

        $response->setStatusCode($code, $message);
        return $response;
    }
}
