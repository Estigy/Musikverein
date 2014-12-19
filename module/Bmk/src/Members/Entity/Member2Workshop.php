<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_mitglieder2kurse")
*/
class Member2Workshop extends Entity
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
    * @ORM\ManyToOne(targetEntity="Workshop")
    * @ORM\JoinColumn(name="id_kurs")
    * 
    * @var Instrument
    */
    protected $workshop;
    
    /**
    * @ORM\ManyToOne(targetEntity="Member", inversedBy="member2workshops")
    * @ORM\JoinColumn(name="id_mitglied")
    * 
    * @var Member
    */
    protected $member;
    
    /**
    * @ORM\Column(name="zusatz")
    * 
    * @var string
    */
    protected $infos;
}