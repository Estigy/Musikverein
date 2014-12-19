<?php

namespace Sheetmusic\Controller;

use Application\Controller\BaseController;

use Sheetmusic\Entity\Piece;
use Sheetmusic\Form\PieceFilterForm;
use Sheetmusic\Form\PieceForm;

use Zend\View\Model\ViewModel;

class SheetmusicController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        
        $form = new PieceFilterForm($em);
        if ($form->handleRequest($this->getRequest())) {
            $this->redirect()->toRoute('sheetmusic');
        }
        
        $filters = $form->getFilledValues();
        
        $entities = $em->getRepository('\Sheetmusic\Entity\Piece')->getPaginator($filters, 25);
        
        $page = (int) $this->params()->fromRoute('page', 1);
        $entities->setCurrentPageNumber($page);
        
        return new ViewModel(array(
            'form' => $form,
            'pieces' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Sheetmusic\Entity\Piece', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('sheetmusic');
            }
        } else {
            $entity = new Piece();
        }

        $form = new PieceForm($em);
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
                return $this->redirect()->toRoute('sheetmusic');
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

