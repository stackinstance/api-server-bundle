<?php

/*
 * This file is part of the Api server bundle from Stack Instance.
 *
 * (c) 2016 Ray Kootstra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use StackInstance\ApiServerBundle\Entity\Instance;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * InstanceFixtures
 * @author Ray Kootstra <r.kootstra@stackinstance.com>
 */
class InstanceFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    protected $container;

    /** @var ObjectManager */
    protected $objectManager;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param  ObjectManager $objectManager
     * @return void
     */
    public function load(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        $this->createInstance();

    }

    /**
     * Create instance
     *
     * @return void
     */
    private function createInstance()
    {
        $objectManager = $this->objectManager;

        $tag = new Instance();
        $tag->setTitle('Instance 1');

        $objectManager->persist($tag);
        $objectManager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 100;
    }

    /**
     * Sets the Container.
     *
     * @param  ContainerInterface $container A ContainerInterface instance
     * @return void
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}