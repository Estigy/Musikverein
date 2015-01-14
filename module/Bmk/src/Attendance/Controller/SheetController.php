<?php

namespace Attendance\Controller;

use Application\Controller\BaseController;

use Attendance\Entity\Entry;
use Attendance\Entity\Event;
use Attendance\Entity\Sheet;
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

        $sheet = $this->getEntityFromRouteId('\Members\Entity\Member');
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


    }

    protected function getBaseIndex($band, $year)
    {
        $em    = $this->getEntityManager();
        $index = array();

        $registers = $em->getRepository('\Instruments\Entity\Register')->findEntities(array());

        foreach ($registers as $r) {
            $index[$r->id] = array(

            );
        }

        $members = $em->getRepository('\Members\Entity\Member')->findEntities(array());

    }

}
