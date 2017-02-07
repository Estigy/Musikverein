<?php

namespace Calendar\Service;

use Calendar\Entity\Event;
use DateTime;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Exception;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class GoogleCalendarService implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $calendarId = 'primary';

    /**
     * @param int $eventId
     * @return Google_Service_Calendar_Event
     * @throws Google_Service_Exception
     */
    public function getEvent($eventId)
    {
        // Get the API client and construct the service object.
        $service = $this->getCalendarService();
        try {
            $event = $service->events->get($this->calendarId, $eventId);
        } catch (Google_Service_Exception $e) {
            if ($e->getCode() === 404) {
                // Resource not found
                return null;
            }
            throw $e;
        }

        return $event;
    }

    public function deleteEvent($eventId)
    {
        $service = $this->getCalendarService();
        $service->events->delete($this->calendarId, $eventId);
    }

    public function createEvent(Event $entity)
    {
        $service = $this->getCalendarService();

        $event = new Google_Service_Calendar_Event();

        $this->fillGoogleEventWithEntityData($event, $entity);

        $createdEvent = $service->events->insert($this->calendarId, $event);

        return $createdEvent->getId();
    }

    protected function fillGoogleEventWithEntityData(Google_Service_Calendar_Event $event, Event $entity)
    {
        $event->setSummary($entity->name);
        $event->setLocation($entity->city . ($entity->location ? ' (' . $entity->location . ')' : ''));
        $event->setDescription($entity->boardText);

        /** @var DateTime $start */
        $start = clone $entity->date;
        /** @var DateTime $end */
        $end   = clone ($entity->dateTo ? $entity->dateTo : $entity->date);
        $end->setTime(23, 59);

        $time = null;
        if ($entity->appointmentTime) {
            $time = $entity->appointmentTime;
        } elseif ($entity->beginTime) {
            $time = $entity->beginTime;
        }

        if ($time) {
            $start->setTime($time->format('H'), $time->format('i'));
            if (!$entity->dateTo) {
                $end->setTime($time->format('H') + 2, $time->format('i'));
            }
        } else {
            $start->setTime(0, 1);
        }

        $startDateTime = new Google_Service_Calendar_EventDateTime();
        $startDateTime->setDateTime($start->format(DATE_W3C));
        $event->setStart($startDateTime);

        $endDateTime = new Google_Service_Calendar_EventDateTime();
        $endDateTime->setDateTime($end->format(DATE_W3C));
        $event->setEnd($endDateTime);
    }

    public function updateEvent($eventId, Event $entity)
    {
        $service = $this->getCalendarService();

        $event = $this->getEvent($eventId);

        if (!$event) {
            $event = new Google_Service_Calendar_Event();
        } else {
            $event->setStatus('confirmed');
        }

        $this->fillGoogleEventWithEntityData($event, $entity);

        if ($event->getId()) {
            $updatedEvent = $service->events->update($this->calendarId, $eventId, $event);
        } else {
            $updatedEvent = $service->events->insert($this->calendarId, $event);
        }

        return $updatedEvent->getId();
    }

    /**
     * @return Google_Service_Calendar
     */
    protected function getCalendarService()
    {
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        return $service;
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    protected function getClient()
    {
        $client = new Google_Client();

        $config = $this->getServiceLocator()->get('Config')['calendar']['google_calendar'];

        if (isset($config['calendar_id'])) {
            $this->calendarId = $config['calendar_id'];
        }

        $client->setAuthConfig($config['client_secret_file']);
        $client->setApplicationName($config['application_name']);
        $client->setScopes(array(Google_Service_Calendar::CALENDAR));
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        $credentialsPath = $config['credentials_temp_file'];
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            die();

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode('4/n********************');

            // Store the credentials to disk.
            if(!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $newAccessToken = $client->getAccessToken();
            // Merge new data into old data (only the old data has the refresh_token!)
            $accessToken = array_merge($accessToken, $newAccessToken);
            file_put_contents($credentialsPath, json_encode($accessToken));
        }

        return $client;
    }
}