<?php

/*
 * This file is part of the Api server bundle from Stack Instance.
 *
 * (c) 2016 Ray Kootstra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StackInstance\ApiServerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * InstanceControllerTest
 * @author Ray Kootstra <r.kootstra@stackinstance.com>
 */
class InstanceControllerTest extends WebTestCase
{
    public function testGetInstanceList()
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

    public function testAddInstance()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/instance',
            array(
                'title' => 'Instance 2'
            )
        );

        $this->assertContains(
            '{"success":true,"code":200,"data":"{\u0022data\u0022:{\u0022id\u0022:2,\u0022title\u0022:\u0022Instance 2\u0022}}"}',
            $client->getResponse()->getContent()
        );
    }

    public function testAddInstanceFailMissingTitle()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/instance',
            array()
        );

        $this->assertContains(
            '{"success":false,"code":401,"message":"No title provided"}',
            $client->getResponse()->getContent()
        );
    }

    public function testUpdateInstance()
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/instance/1',
            array(
                'title' => 'Instance new title'
            )
        );

        $this->assertContains(
            '{"success":true,"code":200,"data":"{\u0022data\u0022:{\u0022id\u0022:1,\u0022title\u0022:\u0022Instance new title\u0022}}"}',
            $client->getResponse()->getContent()
        );
    }

    public function testUpdateInstanceFailMissingTitle()
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/instance/1',
            array()
        );

        $this->assertContains(
            '{"success":false,"code":401,"message":"No title provided"}',
            $client->getResponse()->getContent()
        );
    }

    public function testDeleteInstance()
    {
        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/instance/1'
        );

        $this->assertContains(
            '{"success":true,"code":200,"data":"{\u0022deleted\u0022:true}"}',
            $client->getResponse()->getContent()
        );
    }

    public function testDeleteInstanceFailCouldNotDelete()
    {
        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/instance/100'
        );

        $this->assertContains(
            '{"success":false,"code":401,"message":"Could not delete instance"}',
            $client->getResponse()->getContent()
        );
    }
}
