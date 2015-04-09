<?php

namespace Members\Controller;

use Application\Controller\BaseController;

use Members\Entity\Medal;
use Members\Form\MedalForm;

use Zend\View\Model\ViewModel;

class MedalController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $entities = $em->getRepository('\Members\Entity\Medal')->findEntities();

        return new ViewModel(array(
            'medals' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Members\Entity\Medal', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('medals');
            }
        } else {
            $entity = new Medal();
        }

        $form = new MedalForm($em);
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
                return $this->redirect()->toRoute('medals');
            }
        }

        return array(
            'id'   => $entity->id ?: 0,
            'form' => $form,
        );
    }

}
