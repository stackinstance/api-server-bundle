<?php

namespace StackInstance\ApiServerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testAuthorizedIndex()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/instance'
        );

        $this->assertContains(
            '{"success":true,"code":200,"data":"{\u0022data\u0022:[{\u00221\u0022:\u0022Instance 1\u0022}]}"}',
            $client->getResponse()->getContent()
        );
    }
}
