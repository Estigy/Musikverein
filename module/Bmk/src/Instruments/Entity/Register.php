<?php

namespace Instruments\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_instrumente_register")
*/
class Register extends Entity
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
    * @ORM\Column(name="bezeichnung", length=50)
    * 
    * @var string
    */
	protected $name;
    
    /**
    * @ORM\OneToMany(targetEntity="Category", mappedBy="register")
    * 
    * @var array
    */    
    protected $categories;
    
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
}