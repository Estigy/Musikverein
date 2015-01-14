<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_mitgliedschaft")
*/
class Membership extends Entity
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
    * @ORM\ManyToOne(targetEntity="Member")
    * @ORM\JoinColumn(name="id_mitglied")
    * 
    * @var Member
    */
    protected $member;
    
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