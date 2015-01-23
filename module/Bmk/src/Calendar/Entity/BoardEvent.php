<?php

namespace Calendar\Entity;

use DateTime;
use DateInterval;
use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="bmk_calendar_events")
*/
class BoardEvent extends Entity
{
    /**
    * @ORM\Id
    * @ORM\Column(name="eventid",type="integer")
    * @ORM\GeneratedValue
    *
    * @var integer
    */
	protected $id;

    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $userid;

    /**
    * @ORM\Column(name="year", type="integer")
    *
    * @var integer
    */
    protected $year;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $month;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $mday;
    /**
    * @ORM\Column(type="string")
    *
    * @var string
    */
    protected $title;
    /**
    * @ORM\Column(type="string")
    *
    * @var string
    */
    protected $event_text;

    /**
    * @ORM\Column(type="string")
    *
    * @var string
    */
    protected $read_perms;

    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $unix_stamp;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $priv_event;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $show_emoticons;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $rating;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $event_ranged;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $event_repeat;
    /**
    * @ORM\Column(type="string")
    *
    * @var string
    */
    protected $repeat_unit;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $end_day;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $end_month;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $end_year;
    /**
    * @ORM\Column(type="integer")
    *
    * @var integer
    */
    protected $end_unix_stamp;
    /**
    * @ORM\Column
    *
    * @var string
    */
    protected $event_bgcolor;
    /**
    * @ORM\Column
    *
    * @var string
    */
    protected $event_color;

    public function __construct()
    {
        $this->userid = 1;
        $this->read_perms = '*';
        $this->priv_event = 0;
        $this->show_emoticons = 1;
        $this->rating = 1;
        $this->event_ranged = 0;
        $this->event_repeat = 0;
        $this->repeat_unit = 'w';
        $this->end_day = 0;
        $this->end_month = 0;
        $this->end_year = 0;
        $this->end_unix_stamp = 944002799;
        $this->event_bgcolor = 'darkblue';
        $this->event_color = 'white';
    }

    public function setDate(DateTime $date)
    {
        $this->year = $date->format('Y');
        $this->month = $date->format('m');
        $this->mday = $date->format('d');
        
        // Für die Berechnung des Unix-Timestamps die Uhrzeit auf 23:59:59 setzen
        $date->add(new DateInterval('PT23H59M59S'));
        
        $this->unix_stamp = $date->getTimestamp();
    }
}