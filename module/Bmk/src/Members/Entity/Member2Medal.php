<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_mitglieder2abzeichen")
*/
class Member2Medal extends Entity
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
    * @ORM\ManyToOne(targetEntity="Medal")
    * @ORM\JoinColumn(name="id_abzeichen")
    * 
    * @var Instrument
    */
    protected $medal;
    
    /**
    * @ORM\ManyToOne(targetEntity="Member", inversedBy="member2medals")
    * @ORM\JoinColumn(name="id_mitglied")
    * 
    * @var Member
    */
    protected $member;
    
    /**
    * @ORM\Column(name="datum", type="date")
    * 
    * @var DateTime
    */
    protected $date;
    
    /**
    * @ORM\Column(name="zusatz")
    * 
    * @var string
    */
    protected $infos;
}