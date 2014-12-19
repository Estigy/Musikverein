<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_mitglieder2orchester")
*/
class Member2Band extends Entity
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
    * @ORM\ManyToOne(targetEntity="Member", inversedBy="member2bands")
    * @ORM\JoinColumn(name="id_mitglied")
    * 
    * @var Member
    */
    protected $member;
    
    /**
    * @ORM\Column(name="orchester", length=3)
    * 
    * @var string
    */
    protected $band;
    
    /**
    * @ORM\Column(name="eintritt", type="date")
    * 
    * @var DateTime
    */
    protected $beginDate;

    /**
    * @ORM\Column(name="austritt", type="date")
    * 
    * @var DateTime
    */
    protected $endDate;
}