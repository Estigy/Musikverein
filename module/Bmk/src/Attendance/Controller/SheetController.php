<?php

namespace Attendance\Controller;

use Application\Controller\BaseController;

use Attendance\Entity\Sheet;
use Attendance\Form\SheetForm;

use Zend\View\Model\ViewModel;

class AttendanceController extends BaseController
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

    public function entriesAction()
    {
        $em = $this->getEntityManager();

        $entity = $this->getEntityFromRouteId('\Members\Entity\Member');
        if (!$entity) {
            return $this->redirect()->toRoute('members');
        }

        $members = $em->getRepository('\Members\Entity\Member')->findEntities(array());


    }

}
