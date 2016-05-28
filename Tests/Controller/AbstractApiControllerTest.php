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

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpKernel\Client;

/**
 * AbstractApiControllerTest
 */
class AbstractApiControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager $entityManager
     */
    protected $entityManager;

    /** @var  Client $client */
    protected $client;

    /** @var  Application $application */
    protected $application;

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->application->getKernel()->getContainer();
    }

    public function setUp()
    {
        $this->client = static::createClient();

        $kernel = new \AppKernel("test", true);
        $kernel->boot();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
        $this->runConsole("doctrine:da:dr", array("--force" => true));
        $this->runConsole("doctrine:da:cr");

        $command = new CreateSchemaDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:schema:create --force',
        ));
        $command->run($input, new ConsoleOutput());

        $this->runConsole("doctrine:fixtures:load", array("--fixtures" => __DIR__ . "/../../DataFixtures"));
        $this->entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();

    }

    /**
     * @param $command
     * @param array $options
     *
     * @return mixed
     */
    protected function runConsole($command, Array $options = array())
    {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $this->application->run(new ArrayInput($options));
    }

    public function testNoTest()
    {
        $this->assertEquals(true, true);
    }
}