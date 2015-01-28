<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Members\Repository\Workshop")
* @ORM\Table(name="lt_kurse")
*/
class Workshop extends Entity
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
    * @ORM\Column(name="name", length=128)
    * 
    * @var string
    */
    protected $name;
    
}