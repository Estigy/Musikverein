<?php

namespace Members\Controller;

use Application\Controller\BaseController;

use Members\Entity\Workshop;
use Members\Form\WorkshopForm;

use Zend\View\Model\ViewModel;

class WorkshopController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $entities = $em->getRepository('\Members\Entity\Workshop')->getPaginator(array(), 25);

        $page = (int) $this->params()->fromRoute('page', 1);
        $entities->setCurrentPageNumber($page);

        return new ViewModel(array(
            'workshops' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Members\Entity\Workshop', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('workshops');
            }
        } else {
            $entity = new Workshop();
        }

        $form = new WorkshopForm($em);
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
                return $this->redirect()->toRoute('workshops');
            }
        }

        return array(
            'id'   => $entity->id ?: 0,
            'form' => $form,
        );
    }
}

