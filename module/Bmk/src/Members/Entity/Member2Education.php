<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_mitglieder2unterricht")
*/
class Member2Education extends Entity
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
    * @ORM\ManyToOne(targetEntity="Member", inversedBy="member2medals")
    * @ORM\JoinColumn(name="id_mitglied")
    * 
    * @var Member
    */
    protected $member;
    
    /**
    * @ORM\ManyToOne(targetEntity="\Bmk\Entity\Register")
    * @ORM\JoinColumn(name="instrument")
    * 
    * @var Category
    */
    protected $register;
    
    /**
    * @ORM\Column(name="lehrer", nullable=true)
    * 
    * @var string
    */
    protected $teacher;

    /**
    * @ORM\Column(name="gruppe", nullable=true)
    * 
    * @var string
    */
    protected $group;
    
    /**
    * @ORM\Column(name="beginn", type="integer", nullable=true)
    * 
    * @var integer
    */
    protected $beginYear;

    /**
    * @ORM\Column(name="ende", type="integer", nullable=true)
    * 
    * @var integer
    */
    protected $endYear;
    
}