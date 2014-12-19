<?php

namespace Documents\Entity;

use Application\Entity\Entity;
use Application\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Documents\Repository\Document")
* @ORM\Table(name="lt_dokumente")
*/
class Document extends Entity
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
    * @ORM\Column(name="dateiname", length=255)
    * 
    * @var string
    */
    protected $filename;
    
    /**
    * @ORM\Column(name="hochgeladen_am", type="datetime")
    * 
    * @var string
    */
    protected $uploadDate;
    
    /**
    * @ORM\ManyToOne(targetEntity="Application\Entity\User")
    * @ORM\JoinColumn(name="hochgeladen_von")
    * 
    * @var User
    */
    protected $uploadUser;

    /**
    * @ORM\ManyToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="id_kategorie")
    * 
    * @var Category
    */
    protected $category;

    /**
    * @ORM\Column(name="beschreibung", length=255, nullable=true)
    * 
    * @var string
    */
    protected $description;
    
    /**
    * @ORM\Column(name="referenz_datum", type="datetime", nullable=true)
    * 
    * @var string
    */
    protected $referenceDate;
    
    /**
    * @ORM\Column(name="anmerkungen", type="text", nullable=true)
    * 
    * @var string
    */
    protected $comment;
    
    /**
    * @ORM\Column(name="hash", length=255)
    * 
    * @var string
    */
    protected $hash;
    
    public function getExtension()
    {
        $pieces = explode('.', $this->filename);
        return array_pop($pieces);
    }
    
}