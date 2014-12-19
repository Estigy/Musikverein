<?php

namespace Documents\Controller;

use Application\Controller\BaseController;

use Documents\Entity\Document;
use Documents\Form\DocumentFilterForm;
use Documents\Form\DocumentForm;

use Zend\View\Model\ViewModel;

class DocumentController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        
        $form = new DocumentFilterForm($em);
        if ($form->handleRequest($this->getRequest())) {
            $this->redirect()->toRoute('documents');
        }
        
        $filters = $form->getFilledValues();
        
        $entities = $em->getRepository('\Documents\Entity\Document')->getPaginator($filters, 25);
        
        $page = (int) $this->params()->fromRoute('page', 1);
        $entities->setCurrentPageNumber($page);
        
        return new ViewModel(array(
            'form' => $form,
            'documents' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Documents\Entity\Document', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('documents');
            }
        } else {
            $entity = new Document();
        }

        $form = new DocumentForm($em);
        $form->bind($entity);

        if ($entity->id == null) {
            $form->get('submit')->setValue('Hinzufügen');
        };

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                if ($entity->id === null) {
                    // Daten ergänzen
                }
                
                $em->persist($entity);
                $em->flush();
                return $this->redirect()->toRoute('documents');
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

