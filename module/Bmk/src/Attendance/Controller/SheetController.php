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
        $em = $this->getEntityManager();

        $sheet = $this->getEntityFromRouteId('\Attendance\Entity\Sheet');
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

        $index = $this->getBaseIndex($sheet->band, $sheet->year);

        return array(
            'id'      => $sheet->id ?: 0,
            'eventId' => $event->id ?: 0,
            'index'   => $index,
            'sheet'   => $sheet,
            'event'   => $event,
            'form'    => $form,
        );
    }

    protected function getBaseIndex($band, $year)
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
