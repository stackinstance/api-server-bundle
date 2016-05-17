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
            '/api/instance',
            array(
                'apikey' => '8CvZWry5EcxU6wC7PARxcN36bG6f5ybE',
                'apisecret' => 'zPBGWZC3hduxKsxXpzhR2dwhZPLMBPfu9nKNk46SSvXsDjfwMJrttbnMeKT4T4Vt'
            )
        );

        $this->assertContains(
            '{"success":true,"code":200,"data":"{\u0022data\u0022:\u0022Ok\u0022}"}',
            $client->getResponse()->getContent()
        );
    }
}
