<?php

namespace Attendance\Controller;

use Application\Controller\BaseController;

use Attendance\Entity\Entry;
use Attendance\Entity\Event;
use Attendance\Entity\Sheet;
use Attendance\Form\EventForm;
use Attendance\Form\SheetForm;

use Zend\View\Model\ViewModel;

class SheetController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $entities = $em->getRepository('\Attendance\Entity\Sheet')->getPaginator();

        return new ViewModel(array(
            'sheets' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Attendance\Entity\Sheet', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('attendance');
            }
        } else {
            $entity = new Sheet();
        }

        $form = new SheetForm($em);
        $form->bind($entity);

        if ($entity->id == null) {
            $form->get('submit')->setValue('Hinzufügen');
        };

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect()->toRoute('attendance');
            }
        }

        return array(
            'id'   => $entity->id ?: 0,
            'form' => $form,
        );
    }

    public function eventAction()
    {
        $em      = $this->getEntityManager();
        $request = $this->getRequest();

        $sheet   = $this->getEntityFromRouteId('\Attendance\Entity\Sheet');
        if (!$sheet) {
            return $this->redirect()->toRoute('attendance');
        }

        $eventId = $this->params()->fromRoute('eventId');
        if ($eventId) {
            $event = $em->find('\Attendance\Entity\Event', $eventId);
            if ($event === null) {
                return $this->redirect()->toRoute('attendance', array('id' => $sheet->id));
            }
        } else {
            $event = new Event();
            $event->sheet = $sheet;
        }

        $form = new EventForm($em);
        $form->bind($event);

        $index   = $this->getRegisterMemberData($sheet->band, $sheet->year);
        $entries = array();

        foreach ($index as $register) {
            foreach ($register['members'] as $member) {
                $entry = null;
                // Wenn wir ein Event bearbeiten, dann versuchen den gespeicherten Eintrag zu finden
                if ($event->id !== null) {
                    $entry = $em->find('\Attendance\Entity\Entry', array('event' => $event->id, 'member' => $member->id));
                }
                // Wenn es den Eintrag nicht gibt oder wir bei einem völlig neuen Event sind, dann neu anlegen
                if ($entry === null) {
                    $entry = new Entry();
                    $entry->event = $event;
                    $entry->member = $member;
                }
                $entries[$member->id] = $entry;
            }
        }

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $postData = $request->getPost();
            $form->setData($request->getPost());

            foreach ($entries as $memberId => $entry) {
                if (!isset($postData['entries'][$memberId])) {
                    continue;
                }
                $entry->status = $postData['entries'][$memberId];
            }

            if ($form->isValid()) {
                $em->persist($event);
                $em->flush();

                foreach ($entries as $entry) {
                    $em->persist($entry);
                }
                $em->flush();
                return $this->redirect()->toRoute('attendance');
            }
        }


        return array(
            'id'      => $sheet->id ?: 0,
            'eventId' => $event->id ?: 0,
            'index'   => $index,
            'sheet'   => $sheet,
            'event'   => $event,
            'entries' => $entries,
            'form'    => $form,
        );
    }

    protected function tableAction()
    {
        $sheet = $this->getEntityFromRouteId('\Attendance\Entity\Sheet');
        if (!$sheet) {
            return $this->redirect()->toRoute('attendance');
        }

        $index = $this->getRegisterMemberData($sheet->band, $sheet->year);

        $entries = array();

        foreach ($sheet->events as $event) {
            foreach ($event->entries as $entry) {
                $entries[$event->id][$entry->member->id] = $entry;
            }
        }

        return array(
            'sheet'   => $sheet,
            'index'   => $index,
            'entries' => $entries,
        );
    }

    protected function getRegisterMemberData($band, $year)
    {
        $em    = $this->getEntityManager();
        $index = array();

        // Wenn wir im aktuellen Jahr sind, nehmen wir den Stand des heutigen Tages.
        // Bei einem vergangenen Jahr nehmen wir jenen Stand, der zu Jahresende gegolten hat.
        if ($year == date('Y')) {
            $date = $year . date('-m-d');
        } else {
            $date = $year . '-12-31';
        }

        // Alle Register
        $registers = $em->getRepository('\Bmk\Entity\Register')->findEntities(array());

        foreach ($registers as $r) {
            $member2bands = $em->getRepository('\Members\Entity\Member2Band')->findEntities(array(
                'register' => $r->id,
                'band' => $band,
                'date' => $date,
            ));
            $data = array(
                'registerName' => $r->name,
                'members' => array()
            );
            foreach ($member2bands as $m2b) {
                $data['members'][] = $m2b->member;
            }
            usort($data['members'], function($a, $b) {
                $aName = $a->lastname . ' ' . $a->firstname;
                $bName = $b->lastname . ' ' . $b->firstname;
                if ($aName < $bName) return -1;
                if ($aName > $bName) return 1;
                return 0;
            });
            $index[$r->id] = $data;
        }

        return $index;
    }

}
