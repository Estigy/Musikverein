<?php

namespace Bmk\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Bmk\Repository\Register")
* @ORM\Table(name="lt_register")
*/
class Register extends Entity
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
    * @ORM\Column(name="bezeichnung", length=50)
    *
    * @var string
    */
	protected $name;

    /**
     * @ORM\Column(name="sortierung_instrumente", type="integer")
     *
     * @var integer
     */
    protected $sortingForInstruments;

    /**
     * @ORM\Column(name="sortierung_listen", type="integer")
     *
     * @var integer
     */
    protected $sortingForAttendance;

    /**
    * @ORM\OneToMany(targetEntity="\Instruments\Entity\Category", mappedBy="register")
    *
    * @var array
    */
    protected $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
}
