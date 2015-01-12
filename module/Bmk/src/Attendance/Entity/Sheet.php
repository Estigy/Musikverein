<?php

namespace Attendance\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Attendance\Repository\List")
* @ORM\Table(name="lt_anwesenheit_listen")
*/
class Sheet extends Entity
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
    * @ORM\Column(name="orchester",length=128)
    * 
    * @var string
    */
	protected $band;

    /**
     * @ORM\Column(type="integer",name="jahr",length=128)
     *
     * @var integer
     */
    protected $year;
}