<?php

namespace Attendance\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_anwesenheit_events")
*/
class Event extends Entity
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
    * @ORM\ManyToOne(targetEntity="Sheet", inversedBy="events")
    * @ORM\JoinColumn(name="id_liste")
    *
    * @var Sheet
    */
    protected $sheet;

    /**
    * @ORM\Column(type="date")
    *
    * @var DateTime
    */
    protected $date;

    /**
    * @ORM\Column(type="string", nullable=true)
    *
    * @var string
    */
	protected $name;

    /**
    * @ORM\OneToMany(targetEntity="Entry", mappedBy="event")
    *
    * @var array
    */
    protected $entries;


    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

}