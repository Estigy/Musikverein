<?php

namespace Members\Controller;

use Application\Controller\BaseController;

use Members\Entity\Member;
use Members\Entity\Membership;
use Members\Entity\Member2Band;
use Members\Entity\Member2Medal;
use Members\Entity\Member2Role;
use Members\Entity\Member2Workshop;
use Members\Form\MemberFilterForm;
use Members\Form\MemberForm;
use Members\Form\MembershipForm;
use Members\Form\Member2BandForm;
use Members\Form\Member2MedalForm;
use Members\Form\Member2RoleForm;
use Members\Form\Member2WorkshopForm;

use Zend\Navigation\Service\ConstructedNavigationFactory;
use Zend\View\Model\ViewModel;

class MemberController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $form = new MemberFilterForm($em);
        if ($form->handleRequest($this->getRequest())) {
            $this->redirect()->toRoute('members');
        }

        $filters = $form->getFilledValues();

        $entities = $em->getRepository('\Members\Entity\Member')->getPaginator($filters, 25);

        $page = (int) $this->params()->fromRoute('page', 1);
        $entities->setCurrentPageNumber($page);

        return new ViewModel(array(
            'form' => $form,
            'members' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Members\Entity\Member', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('members');
            }
        } else {
            $entity = new Member();
        }

        $form = new MemberForm($em);
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
                return $this->redirect()->toRoute('members');
            }
        }

        return array(
            'id'   => $entity->id ?: 0,
            'member' => $entity,
            'form' => $form,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }

    public function medalsAction()
    {
        $em = $this->getEntityManager();

        $entity = $this->getEntityFromRouteId('\Members\Entity\Member');
        if (!$entity) {
            return $this->redirect()->toRoute('members');
        }

        $connId = $this->params()->fromRoute('connId');
        if ($connId) {
            $connector = $em->find('\Members\Entity\Member2Medal', $connId);
            if ($connector === null) {
                return $this->redirect()->toRoute('memberMedals', array('id' => $entity->id));
            }
        } else {
            $connector = new Member2Medal();
            $connector->member = $entity;
        }

        $form = new Member2MedalForm($em);
        $form->bind($connector);

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($connector);
                $em->flush();
                return $this->redirect()->toRoute('memberMedals', array('id' => $entity->id));
            }
        }

        return array(
            'id'     => $entity->id,
            'connId' => $connId,
            'member' => $entity,
            'form'   => $form,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }

    public function workshopsAction()
    {
        $em = $this->getEntityManager();

        $entity = $this->getEntityFromRouteId('\Members\Entity\Member');
        if (!$entity) {
            return $this->redirect()->toRoute('members');
        }

        $connId = $this->params()->fromRoute('connId');
        if ($connId) {
            $connector = $em->find('\Members\Entity\Member2Workshop', $connId);
            if ($connector === null) {
                return $this->redirect()->toRoute('memberWorkshops', array('id' => $entity->id));
            }
        } else {
            $connector = new Member2Workshop();
            $connector->member = $entity;
        }

        $form = new Member2WorkshopForm($em);
        $form->bind($connector);

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($connector);
                $em->flush();
                return $this->redirect()->toRoute('memberWorkshops', array('id' => $entity->id));
            }
        }

        return array(
            'id'     => $entity->id,
            'connId' => $connId,
            'member' => $entity,
            'form'   => $form,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }

    public function bandsAction()
    {
        $em = $this->getEntityManager();

        $entity = $this->getEntityFromRouteId('\Members\Entity\Member');
        if (!$entity) {
            return $this->redirect()->toRoute('members');
        }

        $connId = $this->params()->fromRoute('connId');
        if ($connId) {
            $connector = $em->find('\Members\Entity\Member2Band', $connId);
            if ($connector === null) {
                return $this->redirect()->toRoute('memberBands', array('id' => $entity->id));
            }
        } else {
            $connector = new Member2Band();
            $connector->member = $entity;
        }

        $form = new Member2BandForm($em);
        $form->bind($connector);

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($connector);
                $em->flush();
                return $this->redirect()->toRoute('memberBands', array('id' => $entity->id));
            }
        }

        return array(
            'id'     => $entity->id,
            'connId' => $connId,
            'member' => $entity,
            'form'   => $form,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }

    public function membershipAction()
    {
        $em = $this->getEntityManager();

        $entity = $this->getEntityFromRouteId('\Members\Entity\Member');
        if (!$entity) {
            return $this->redirect()->toRoute('members');
        }

        $connId = $this->params()->fromRoute('connId');
        if ($connId) {
            $connector = $em->find('\Members\Entity\Membership', $connId);
            if ($connector === null) {
                return $this->redirect()->toRoute('memberMembership', array('id' => $entity->id));
            }
        } else {
            $connector = new Membership();
            $connector->member = $entity;
        }

        $form = new MembershipForm($em);
        $form->bind($connector);

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($connector);
                $em->flush();
                return $this->redirect()->toRoute('memberMembership', array('id' => $entity->id));
            }
        }

        return array(
            'id'     => $entity->id,
            'connId' => $connId,
            'member' => $entity,
            'form'   => $form,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }

    public function rolesAction()
    {
        $em = $this->getEntityManager();

        $entity = $this->getEntityFromRouteId('\Members\Entity\Member');
        if (!$entity) {
            return $this->redirect()->toRoute('members');
        }

        $connId = $this->params()->fromRoute('connId');
        if ($connId) {
            $connector = $em->find('\Members\Entity\Member2Role', $connId);
            if ($connector === null) {
                return $this->redirect()->toRoute('memberRoles', array('id' => $entity->id));
            }
        } else {
            $connector = new Member2Role();
            $connector->member = $entity;
        }

        $form = new Member2RoleForm($em);
        $form->bind($connector);

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($connector);
                $em->flush();
                return $this->redirect()->toRoute('memberRoles', array('id' => $entity->id));
            }
        }

        return array(
            'id'     => $entity->id,
            'connId' => $connId,
            'member' => $entity,
            'form'   => $form,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }

    protected function getTabnav($id = null)
    {
        $id = (int) $id;

        $config = array(
            array(
                'label' => 'Stammdaten',
                'route' => 'memberEdit',
                'params' => array(
                    'id' => $id
                ),
            ),
            array(
                'label' => 'Verleihungen',
                'route' => 'memberMedals',
                'params' => array(
                    'id' => $id
                ),
                'visible' => $id != 0,
            ),
            array(
                'label' => 'Kurse',
                'route' => 'memberWorkshops',
                'params' => array(
                    'id' => $id
                ),
                'visible' => $id != 0,
            ),
            array(
                'label' => 'Orchester',
                'route' => 'memberBands',
                'params' => array(
                    'id' => $id
                ),
                'visible' => $id != 0,
            ),
            array(
                'label' => 'Mitgliedschaft',
                'route' => 'memberMembership',
                'params' => array(
                    'id' => $id
                ),
                'visible' => $id != 0,
            ),
            array(
                'label' => 'Funktionen',
                'route' => 'memberRoles',
                'params' => array(
                    'id' => $id
                ),
                'visible' => $id != 0,
            ),
        );

        $factory = new ConstructedNavigationFactory($config);
        return $factory->createService($this->getServiceLocator());
    }

}

