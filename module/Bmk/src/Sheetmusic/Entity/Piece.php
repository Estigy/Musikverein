<?php

namespace Sheetmusic\Entity;

use Application\Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Sheetmusic\Repository\Piece")
* @ORM\Table(name="lt_noten")
*/
class Piece extends Entity
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
    * @ORM\Column(name="titel", type="string", length=50)
    * 
    * @var string
    */
    protected $title;
    
    /**
    * @ORM\Column(name="komponist", type="string", length=50, nullable=true)
    * 
    * @var string
    */
    protected $composer;
    
    /**
    * @ORM\Column(name="bearbeiter", type="string", length=50, nullable=true)
    * 
    * @var string
    */
	protected $arranger;
    
    /**
    * @ORM\Column(name="verlag", type="string", length=50, nullable=true)
    * 
    * @var string
    */
    protected $publisher;

    /**
    * @ORM\Column(name="jahr", type="integer", nullable=true)
    * 
    * @var integer
    */
    protected $year;
    
    /**
    * @ORM\OneToMany(targetEntity="Piece", mappedBy="archivedAt")
    * 
    * @var array
    */
    protected $piecesOnThisSheet;
    
    /**
    * @ORM\ManyToOne(targetEntity="Piece", inversedBy="piecesOnThisSheet")
    * @ORM\JoinColumn(name="archiviertUnter", nullable=true)
    * 
    * @var Piece
    */
    protected $archivedAt;
    
    /**
    * @ORM\ManyToOne(targetEntity="Genre")
    * @ORM\JoinColumn(name="idNotenGenre", nullable=true)
    * 
    * @var integer
    */
    protected $genre;

    /**
    * @ORM\Column(name="unbrauchbar", type="boolean")
    * 
    * @var boolean
    */
    protected $isUnusable;

    /**
    * @ORM\Column(name="ausgelagert", type="boolean")
    * 
    * @var boolean
    */
    protected $isAway;

    /**
    * @ORM\Column(name="eingescannt", type="integer")
    * 
    * @var integer
    */
    protected $isScanned;

    /**
    * @ORM\Column(name="anmerkungen", type="text", nullable=true)
    * 
    * @var string
    */
    protected $comment;
    
    public function __construct()
    {
        $this->piecesOnThisSheet = new ArrayCollection();
    }

}