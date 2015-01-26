<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Members\Repository\Medal")
* @ORM\Table(name="lt_abzeichen")
*/
class Medal extends Entity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    * 
    * @var integer
    */
	protected $id;
    
    /**
    * @ORM\Column(name="bezeichnung",length=128)
    * 
    * @var string
    */
	protected $name;
	
    /**
     * @ORM\Column(name="sortierung", type="integer")
     *
     * @var integer
     */
    protected $sorting;
}