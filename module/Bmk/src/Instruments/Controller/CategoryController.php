<?php

namespace Instruments\Controller;

use Application\Controller\BaseController;

use Instruments\Entity\Category;
use Instruments\Form\CategoryFilterForm;
use Instruments\Form\CategoryForm;

use Zend\View\Model\ViewModel;

class CategoryController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        
        $entities = $em->getRepository('\Instruments\Entity\Register')->findAll();
        
        return new ViewModel(array(
            'registers' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Instruments\Entity\Category', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('instrumentCategories');
            }
        } else {
            $entity = new Category();
        }

        $form = new CategoryForm($em);
        $form->bind($entity);

        if ($entity->id == 0) {
            $form->get('submit')->setValue('Hinzufügen');
        };

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect()->toRoute('instrumentCategories');
            }
        }

        return array(
            'id'   => $entity->id,
            'form' => $form,
        );
    }

}
