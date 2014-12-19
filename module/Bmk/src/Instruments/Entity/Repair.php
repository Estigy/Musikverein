<?php

namespace Instruments\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_instrumente_service")
*/
class Repair extends Entity
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
    * @ORM\ManyToOne(targetEntity="Instrument", inversedBy="repairs")
    * @ORM\JoinColumn(name="id_instrument")
    * 
    * @var Instrument
    */
    protected $instrument;
    
    /**
    * @ORM\Column(name="datum", type="date", nullable=true)
    * 
    * @var DateTime
    */
    protected $date;
    
    /**
    * @ORM\Column(name="firma", length=50, nullable=true)
    * 
    * @var DateTime
    */
    protected $company;
    
    /**
    * @ORM\Column(name="beschreibung", type="text", nullable=true)
    * 
    * @var DateTime
    */
    protected $description;
    
    /**
    * @ORM\Column(name="anmerkungen", type="text", nullable=true)
    * 
    * @var DateTime
    */
    protected $comment;
    
}