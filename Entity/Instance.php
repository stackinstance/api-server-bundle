<?php

/*
 * This file is part of the Api server bundle from Stack Instance.
 *
 * (c) 2016 Ray Kootstra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StackInstance\ApiServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instance
 *
 * @ORM\Table(name="instance")
 * @ORM\Entity(repositoryClass="StackInstance\ApiServerBundle\Repository\InstanceRepository")
 */
class Instance
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Instance
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}

