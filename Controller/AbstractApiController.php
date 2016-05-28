<?php

/*
 * This file is part of the Api server bundle from Stack Instance.
 *
 * (c) 2016 Ray Kootstra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StackInstance\ApiServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractApiController
 * @package StackInstance\ApiServerBundle\Controller
 * @author Ray Kootstra <r.kootstra@stackinstance.com>
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

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        // add your own authorization here

        return true;
    }
}
