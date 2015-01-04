<?php

namespace Calendar\Controller;

use Application\Controller\BaseController;

use Calendar\Entity\Event;
use Calendar\Entity\BoardEvent;
use Calendar\Form\EventFilterForm;
use Calendar\Form\EventForm;
use Calendar\Form\DemoForm;

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

        $entities = $em->getRepository('\Calendar\Entity\Event')->getPaginator($filters, 25);

        return new ViewModel(array(
            'form' => $form,
            'events' => $entities,
        ));
    }

    public function editAction()
    {
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
}
