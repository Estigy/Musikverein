<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_funktionen")
*/
class Role extends Entity
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
    * @ORM\Column(name="name",length=128)
    * 
    * @var string
    */
    protected $name;

    /**
    * @ORM\Column(name="vorstand", type="boolean")
    * 
    * @var bool
    */
	protected $board;
    
    /**
    * @ORM\Column(name="order", type="integer")
    * 
    * @var integer
    */
    protected $order;

}