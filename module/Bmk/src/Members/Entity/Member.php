<?php

namespace Members\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Members\Repository\Member")
* @ORM\Table(name="lt_mitglieder")
*/
class Member extends Entity
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
    * @ORM\Column(name="title", length=32)
    * 
    * @var string
    */
    protected $title;
    
    /**
    * @ORM\Column(name="firstname", length=32)
    * 
    * @var string
    */
    protected $firstname;
    
    /**
    * @ORM\Column(name="lastname", length=32)
    * 
    * @var string
    */
    protected $lastname;
    
    /**
    * @ORM\Column(name="address", length=64)
    * 
    * @var string
    */
    protected $address;
    
    /**
    * @ORM\Column(name="zip", length=6)
    * 
    * @var string
    */
    protected $zip;
    
    /**
    * @ORM\Column(name="city", length=32)
    * 
    * @var string
    */
    protected $city;
    
    /**
    * @ORM\Column(name="birthdate", type="date")
    * 
    * @var DateTime
    */
    protected $birthDate;
    
    /**
    * @ORM\Column(name="birthcity", length=64)
    * 
    * @var string
    */
    protected $birthCity;
    
    /**
    * @ORM\Column(name="email_priv", length=64)
    * 
    * @var string
    */
    protected $email1;
    
    /**
    * @ORM\Column(name="email_work", length=64)
    * 
    * @var string
    */
    protected $email2;
    
    /**
    * @ORM\Column(name="tel_priv", length=64)
    * 
    * @var string
    */
    protected $phone1;
    
    /**
    * @ORM\Column(name="tel_mobile1", length=64)
    * 
    * @var string
    */
    protected $phone2;
    
    /**
    * @ORM\Column(name="board_user", length=64)
    * 
    * @var string
    */
    protected $boardUser;
    
    /**
    * @ORM\Column(name="vordienst_jahre", length=64)
    * 
    * @var string
    */
    protected $preYears;
    
    /**
    * @ORM\Column(name="vordienst_anmerkung", type="text")
    * 
    * @var string
    */
    protected $preYearsComment;
    
    /**
    * @ORM\Column(name="anmerkungen", type="text")
    * 
    * @var string
    */
    protected $comment;
    
    /**
    * @ORM\Column(name="status", type="integer")
    * 
    * @var integer
    */
    protected $status;
    
    /**
    * @ORM\OneToMany(targetEntity="\Instruments\Entity\Instrument2Member", mappedBy="member")
    * 
    * @var array
    */
    protected $instrument2members;
    
    /**
    * @ORM\OneToMany(targetEntity="\Members\Entity\Member2Medal", mappedBy="member")
    * 
    * @var array
    */
    protected $member2medals;
    
    /**
    * @ORM\OneToMany(targetEntity="\Members\Entity\Member2Workshop", mappedBy="member")
    * 
    * @var array
    */
    protected $member2workshops;
    
    /**
    * @ORM\OneToMany(targetEntity="\Members\Entity\Member2Band", mappedBy="member")
    * 
    * @var array
    */
    protected $member2bands;
    
    /**
    * @ORM\OneToMany(targetEntity="\Members\Entity\Member2Role", mappedBy="member")
    * 
    * @var array
    */
    protected $member2roles;
    
    
    public function __construct()
    {
        $this->instrument2members = new ArrayCollection();
        $this->member2medals      = new ArrayCollection();
        $this->members2workshops  = new ArrayCollection();
        $this->member2bands       = new ArrayCollection();
        $this->member2roles       = new ArrayCollection();
    }    
}