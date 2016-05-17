<?php

namespace StackInstance\ApiServerBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
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
        $this->runConsole("doctrine:mi:mi");
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
}