<?php

namespace Instruments\Entity;

use Application\Entity\Entity;

use Instruments\Entity\Instrument;
use Members\Entity\Member;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Instruments\Repository\Instrument2Member")
* @ORM\Table(name="lt_instrumente_verleih")
*/
class Instrument2Member extends Entity
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
    * @ORM\ManyToOne(targetEntity="Instrument", inversedBy="members")
    * @ORM\JoinColumn(name="id_instrument")
    * 
    * @var Instrument
    */
    protected $instrument;
    
    /**
    * @ORM\ManyToOne(targetEntity="\Members\Entity\Member", inversedBy="instrument2members")
    * @ORM\JoinColumn(name="id_person")
    * 
    * @var Member
    */
    protected $member;
    
    /**
    * @ORM\Column(name="ausgabe", type="date", nullable=true)
    * 
    * @var DateTime
    */
    protected $giveAwayDate;
    
    /**
    * @ORM\Column(name="ruecknahme", type="date", nullable=true)
    * 
    * @var DateTime
    */
    protected $takeBackDate;

    /**
    * @ORM\ManyToOne(targetEntity="\Members\Entity\Member")
    * @ORM\JoinColumn(name="ausgebender", nullable=true)
    * 
    * @var Member
    */
    protected $giveAwayMember;
    
    /**
    * @ORM\ManyToOne(targetEntity="\Members\Entity\Member")
    * @ORM\JoinColumn(name="ruecknehmender", nullable=true)
    * 
    * @var Member
    */
    protected $takeBackMember;
}