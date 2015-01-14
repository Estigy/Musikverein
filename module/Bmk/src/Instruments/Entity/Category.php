<?php

namespace Instruments\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_instrumente_kategorien")
*/
class Category extends Entity
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
    * @ORM\Column(name="bezeichnung",length=128)
    *
    * @var string
    */
	protected $name;

    /**
    * @ORM\ManyToOne(targetEntity="\Bmk\Entity\Register", inversedBy="categories")
    * @ORM\JoinColumn(name="id_register")
    *
    * @var Register
    */
    protected $register;

    /**
    * @ORM\OneToMany(targetEntity="Instrument", mappedBy="category")
    *
    * @var array
    */
    protected $instruments;


    public function __construct()
    {
        $this->instruments = new ArrayCollection();
        $this->children    = new ArrayCollection();
    }

    public function getInstruments($filter = array())
    {
        $filter['category'] = $this;

        $instruments = $this->getEntityManager()->getRepository('\Instruments\Entity\Instrument')->findEntities($filter);

        return $instruments;
    }
}