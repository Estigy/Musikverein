<?php

namespace Calendar\Controller;

use Application\Controller\BaseController;

use Calendar\Entity\Event;
use Calendar\Entity\BoardEvent;
use Calendar\Form\EventFilterForm;
use Calendar\Form\EventForm;

use Calendar\Service\GoogleCalendarService;
use Zend\View\Model\ViewModel;

class CalendarController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $form = new EventFilterForm($em);
        if ($form->handleRequest($this->getRequest())) {
            $this->redirect()->toRoute('calendar');
        }

        $filters = $form->getFilledValues();

        $entities = $em->getRepository('\Calendar\Entity\Event')->findEntities($filters);

        return new ViewModel(array(
            'form' => $form,
            'events' => $entities,
        ));
    }

    public function editAction()
    {
        /** @var GoogleCalendarService $googleService */
        $googleService = $this->getServiceLocator()->get('GoogleCalendarService');
        //$googleService->doTest();
        //die();
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        if ($id) {
            $entity = $em->find('\Calendar\Entity\Event', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('calendar');
            }
            $entity->boardText = $entity->boardEvent ? $entity->boardEvent->event_text : null;
        } elseif ($this->params()->fromQuery('preload')) {
            $preload = $em->find('\Calendar\Entity\Event', $this->params()->fromQuery('preload'));
            if ($preload === null) {
                return $this->redirect()->toRoute('calendar');
            }
            $entity = clone $preload;
        } else {
            $entity = new Event();
        }

        /** @var Event $entity */

        $form = new EventForm($em);
        $form->bind($entity);
        $form->get('boardText')->setValue(str_replace('<br>', "\n", $entity->boardText)); // nötig, weil nicht vom DoctrineHydrator befüllt

        if ($entity->id == null) {
            $form->get('submit')->setValue('Hinzufügen');
        };

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                if ($entity->showInBoard == 0) { // Keine Anzeige im Board?
                    if ($entity->boardEvent != null) {
                        $em->remove($entity->boardEvent);
                        $entity->boardEvent = null;
                    }
                } else {                         // Anzeige im Board?
                    if ($entity->boardEvent == null) {
                        $entity->boardEvent = new BoardEvent;
                    }
                    $entity->boardEvent->title = $entity->name;
                    $entity->boardEvent->event_text = $form->get('boardText')->getValue();
                    $entity->boardEvent->setDate($entity->date);
                }

                if ($entity->showInGoogleCalendar == 0) { // Keine Anzeige im Google Kalender?
                    if ($entity->googleCalendarId) {
                        $googleService->deleteEvent($entity->googleCalendarId);
                    }
                } else {                                  // Anzeige im Google Kalender?
                    if ($entity->googleCalendarId) {
                        // Event aktualisieren
                        // Falls es inzwischen gelöscht wurde, wird es neu angelegt, daher die ID immer zuweisen
                        $entity->googleCalendarId = $googleService->updateEvent($entity->googleCalendarId, $entity);
                    } else {
                        $entity->googleCalendarId = $googleService->createEvent($entity);
                    }
                }

                $em->persist($entity);
                $em->flush();
                return $this->redirect()->toRoute('calendar');
            }
        }

        return array(
            'id'   => $entity->id ?: 0,
            'form' => $form,
        );
    }

    public function exportAction()
    {
        $em = $this->getEntityManager();

        $form = new EventFilterForm($em);
        $form->handleRequest($this->getRequest());
        $filters = $form->getFilledValues();
        $filters['status'] = 'Fixiert';

        $entities = $em->getRepository('\Calendar\Entity\Event')->findEntities($filters);

        $headers = array(
            'Datum',
            'Datum-Bis',
            'Name',
            'Ort',
            'Location',
            'Typ',
            'Orchester',
        );

        $s = $this->echoCsvData($headers);

        foreach ($entities as $entity) {
            $data = array(
                $entity->date->format('d.m.Y'),
                $entity->dateTo ? $entity->dateTo->format('d.m.Y') : '',
                $entity->name,
                $entity->city,
                $entity->location,
                $entity->type,
                $entity->band ? implode(', ', $entity->band) : '',
            );

            $s .= $this->echoCsvData($data);
        }

        $r = $this->getResponse();

        $r->setContent($s);

        $r->getHeaders()->addHeaders(array(
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'application/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=termine.xls',
            'Pragma' => 'no-cache',
        ));

        return $r;
    }

    public function printYearAction()
    {
        // Print-Layout
        $this->layout('layout/print');
        $this->layout()->format = 'A3';

        $em = $this->getEntityManager();

        $form = new EventFilterForm($em);
        $form->handleRequest($this->getRequest());
        $filters = $form->getFilledValues();
        //$filters['status'] = 'Fixiert';

        $entities = $em->getRepository('\Calendar\Entity\Event')->findEntities($filters);

        return new ViewModel(array(
            'events' => $entities,
            'year' => $filters['year'],
        ));
    }

    protected function echoCsvData($array)
    {
        $array = array_map('utf8_decode', $array);
        foreach ($array as $key => $data) {
            $array[$key] = '"' . $data . '"';
        }
        return implode("\t", $array) . "\r\n";
    }
}
