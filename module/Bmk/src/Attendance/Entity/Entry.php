<?php

namespace Attendance\Entity;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_anwesenheit_entries")
*/
class Entry extends Entity
{
	const STATUS_PRESENT = 'anwesend';
	const STATUS_ABSENT  = 'abwesend';
	const STATUS_EXCUSED = 'entschuldigt';
	
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
    * @ORM\ManyToOne(targetEntity="AttendanceList")
    * @ORM\JoinColumn(name="id_liste")
    * 
    * @var AttendanceList
    */
    protected $attendanceList;
    
    /**
    * @ORM\Column(type="string")
    * 
    * Einer der STATUS_*-Konstanten
    * 
    * @var string
    */
	protected $status;
    
    
    public static function getStati()
    {
		return array(
			self::STATUS_PRESENT => 'anwesend',
			self::STATUS_ABSENT  => 'abwesend',
			self::STATUS_EXCUSED => 'entschuldigt',
		);
    }
}