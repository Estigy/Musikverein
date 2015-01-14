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
    * @ORM\ManyToOne(targetEntity="Member")
    * @ORM\JoinColumn(name="id_mitglied")
    *
    * @var Member
    */
    protected $member;

    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Event")
    * @ORM\JoinColumn(name="id_event")
    *
    * @var Event
    */
    protected $event;

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