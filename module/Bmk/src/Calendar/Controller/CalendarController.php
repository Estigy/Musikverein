<?php

namespace Calendar\Controller;

use Application\Controller\BaseController;

use Calendar\Entity\Event;
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
                return $this->redirect()->toRoute('calendar', array('action' => 'index'));
            }
        } else {
            $entity = new Event();
        }

        $form = new EventForm($em);
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
                return $this->redirect()->toRoute('calendar', array('action' => 'index'));
            }
        }

        return array(
            'id'   => $entity->id ?: 0,
            'form' => $form,
        );
    }

    public function deleteAction()
    {

    }
}
