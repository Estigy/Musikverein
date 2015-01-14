<?php

namespace Attendance\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Attendance\Repository\Sheet")
* @ORM\Table(name="lt_anwesenheit_listen")
 *
 * @property integer $id
 * @property string $name
 * @property string $band
 * @property integer $year
*/
class Sheet extends Entity
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
    * @ORM\Column(length=128)
    *
    * @var string
    */
	protected $name;

    /**
    * @ORM\Column(length=128,nullable=true)
    *
    * @var string
    */
	protected $band;

    /**
     * @ORM\Column(type="integer",length=128)
     *
     * @var integer
     */
    protected $year;

    /**
    * @ORM\OneToMany(targetEntity="Event", mappedBy="sheet")
    *
    * @var Sheet
    */
    protected $events;


    public function __construct()
    {
        $this->events = new ArrayCollection();
    }
}