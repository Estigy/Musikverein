<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_mitglieder2funktion")
*/
class Member2Role extends Entity
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
    * @ORM\ManyToOne(targetEntity="Member", inversedBy="member2roles")
    * @ORM\JoinColumn(name="id_mitglied")
    * 
    * @var Member
    */
    protected $member;
    
    /**
    * @ORM\ManyToOne(targetEntity="Role")
    * @ORM\JoinColumn(name="id_funktion")
    * 
    * @var Instrument
    */
    protected $role;
    
    /**
    * @ORM\Column(name="beginn", type="date")
    * 
    * @var DateTime
    */
    protected $beginDate;

    /**
    * @ORM\Column(name="ende", type="date")
    * 
    * @var DateTime
    */
    protected $endDate;
}