<?php

namespace Instruments\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Instruments\Repository\Instrument")
* @ORM\Table(name="lt_instrumente")
*/
class Instrument extends Entity
{
    const STATUS_GIVEN_AWAY = 1;
    const STATUS_IN_ARCHIVE = 2;
    const STATUS_INACTIVE   = 3;
    
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    * 
    * @var integer
    */
	protected $id;
    
    /**
    * @ORM\ManyToOne(targetEntity="Category", inversedBy="instruments")
    * @ORM\JoinColumn(name="idKategorie")
    * 
    * @var integer
    */
    protected $category;
    
    /**
    * @ORM\Column(name="status", type="integer")
    * 
    * @var integer
    */
    protected $status;
    
    /**
    * @ORM\Column(name="marke", length=50, nullable=true)
    * 
    * @var string
    */
    protected $brand;
    
    /**
    * @ORM\Column(name="seriennummer", length=50, nullable=true)
    * 
    * @var string
    */
	protected $serialNumber;
    
    /**
    * @ORM\Column(name="ausfuehrung", length=50, nullable=true)
    * 
    * @var string
    */
    protected $variant;

    /**
    * @ORM\Column(name="ankauf", type="date", nullable=true)
    * 
    * @var DateTime
    */
    protected $buyDate;
    
    /**
    * @ORM\Column(name="ausgeschieden", type="date", nullable=true)
    * 
    * @var DateTime
    */
    protected $outDate;
    
    /**
    * @ORM\Column(name="versicherung", type="text", nullable=true)
    * 
    * @var string
    */
    protected $insurance;

    /**
    * @ORM\Column(name="anmerkungen", type="text", nullable=true)
    * 
    * @var string
    */
    protected $comment;
    
    /**
    * @ORM\OneToMany(targetEntity="Instrument2Member", mappedBy="instrument")
    * @ORM\OrderBy({"giveAwayDate" = "DESC"})
    * 
    * @var array
    */
    protected $instrument2members;
    
    /**
    * @ORM\OneToMany(targetEntity="Repair", mappedBy="instrument")
    * @ORM\OrderBy({"date" = "DESC"})
    * 
    * @var array
    */
    protected $repairs;
    
    
    public function __construct()
    {
        $this->instrument2members = new ArrayCollection();
        $this->repairs  = new ArrayCollection();
    }
    
    public function getCurrentMember()
    {
        if ($this->status != self::STATUS_GIVEN_AWAY) {
            return null;
        }
        
        $i2ms = $this->getEntityManager()->getRepository('\Instruments\Entity\Instrument2Member')->findEntities(array(
            'instrument' => $this,
            'currentOwner' => true
        ));
        foreach ($i2ms as $i2m) {
            return $i2m->member;
        }
    }
}