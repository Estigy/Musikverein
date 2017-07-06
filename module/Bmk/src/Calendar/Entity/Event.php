<?php

namespace Calendar\Entity;

use Application\Entity\Entity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Calendar\Repository\Event")
 * @ORM\Table(name="lt_termine")
 *
 * @property BoardEvent $boardEvent
 * @property int $googleCalendarId
 * @property int $showInGoogleCalendar
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
    * @ORM\Column(name="datum", type="date")
    *
    * @var DateTime
    */
    protected $date;

    /**
    * @ORM\Column(name="datum_bis", type="date", nullable=true)
    *
    * @var DateTime
    */
    protected $dateTo;

    /**
    * @ORM\Column(name="beginn", type="time", nullable=true)
    *
    * @var DateTime
    */
    protected $beginTime;

    /**
    * @ORM\Column(name="treffpunkt", type="time", nullable=true)
    *
    * @var DateTime
    */
    protected $appointmentTime;

    /**
    * @ORM\Column(name="name", type="string", length=50)
    *
    * @var string
    */
    protected $name;

    /**
    * @ORM\Column(name="ort", type="string", length=50, nullable=true)
    *
    * @var string
    */
	protected $city;

    /**
    * @ORM\Column(name="location", type="string", length=50, nullable=true)
    *
    * @var string
    */
    protected $location;

    /**
    * @ORM\Column(name="kapelle", type="json_array", nullable=true)
    *
    * @var string
    */
    protected $band;

    /**
    * @ORM\Column(name="adjustierung", type="string", length=50, nullable=true)
    *
    * @var string
    */
    protected $clothing;

    /**
    * @ORM\Column(name="einordnung", type="string", length=50, nullable=true)
    *
    * @var string
    */
    protected $type;

    /**
    * @ORM\Column(name="kommentar", type="text", nullable=true)
    *
    * @var string
    */
    protected $comment;

    /**
    * @ORM\Column(name="status", type="string", length=50)
    *
    * @var string
    */
    protected $status;

    /**
    * @ORM\Column(name="homepage_anzeige", type="string", length=50)
    *
    * @var integer
    */
    protected $showOnHomepage;

    /**
    * @ORM\Column(name="homepage_text", type="string", length=50, nullable=true)
    *
    * @var string
    */
    protected $homepageText;

    /**
    * @ORM\Column(name="board_anzeige", type="integer")
    *
    * @var integer
    */
    protected $showInBoard;

    /**
    * @ORM\OneToOne(targetEntity="BoardEvent", cascade={"persist"})
    * @ORM\JoinColumn(name="id_bmk_calendar_events", referencedColumnName="eventid", nullable=true)
    *
    * @var BoardEvent
    */
    protected $boardEvent;

    /**
    * @ORM\Column(name="verrechnungsinfo", type="string", length=50, nullable=true)
    *
    * @var string
    */
    protected $accountingInfo;

    /**
    * @ORM\Column(name="rechnungsanschrift", type="string", length=50, nullable=true)
    *
    * @var string
    */
    protected $accountingAddress;

    /**
    * Nicht von Doctrine gemappt, aber vom Formular befüllt!
    *
    * @var string
    */
    protected $boardText;

    /**
     * @ORM\Column(name="google_cal_anzeige", type="integer")
     *
     * @var integer
     */
    protected $showInGoogleCalendar;

    /**
     * @ORM\Column(name="id_google_cal", type="string", length=64, nullable=true)
     *
     * @var integer
     */
    protected $googleCalendarId;

    public static function getTypes()
    {
        return array(
            'Ausrückung'         => 'Ausrückung',
            'Eigenveranstaltung' => 'Eigenveranstaltung',
            'Arbeitseinsatz'     => 'Arbeitseinsatz',
            'Vorstandssithung'   => 'Vorstandssitzung',
            'Information'        => 'Information',
            'Sonstiges'          => 'Sonstiges',
        );
    }

    public static function getStati()
    {
        return array(
            'Anbahnung' => 'Anbahnung',
            'Fixiert'   => 'Fixiert',
            'Abgesagt'  => 'Abgesagt',
        );
    }

    public static function getClothings()
    {
        return array(
            'Uniform'       => 'Uniform',
            'Blaue Leiberl' => 'Blaue Leiberl',
            'Zivil'         => 'Zivil',
            'Arbeitsgewand' => 'Arbeitsgewand',
        );
    }

    public function __clone()
    {
        // Dieses if-Konstrukt ist nötig. Siehe hier:
        // http://doctrine-orm.readthedocs.org/en/latest/cookbook/implementing-wakeup-or-clone.html
        if ($this->id) {
            $this->id = null;
            if ($this->boardEvent) {
                $this->boardText = $this->boardEvent->event_text;
            }
            $this->boardEvent = null;
            $this->googleCalendarId = null;
        }
    }
}