<?php

namespace Instruments\Controller;

use Application\Controller\BaseController;

use Instruments\Entity\Instrument;
use Instruments\Entity\Instrument2Member;
use Instruments\Entity\Repair;
use Instruments\Form\GiveAwayForm;
use Instruments\Form\InstrumentFilterForm;
use Instruments\Form\InstrumentForm;
use Instruments\Form\TakeBackForm;
use Instruments\Form\RepairForm;

use Zend\Navigation\Navigation;
use Zend\View\Model\ViewModel;

use Zend\Navigation\Service\ConstructedNavigationFactory;

class InstrumentController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        
        $form = new InstrumentFilterForm($em);
        if ($form->handleRequest($this->getRequest())) {
            $this->redirect()->toRoute('instruments');
        }
        
        $filters = $form->getFilledValues();
        
        $entities = $em->getRepository('\Instruments\Entity\Register')->findAll();
        
        return new ViewModel(array(
            'form' => $form,
            'registers' => $entities,
            'instrFilter' => $filters,
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();
        
        $entity = $this->getEntityFromRouteId('\Instruments\Entity\Instrument');
        if ($entity === null) { // ID gegebene, aber nicht gefunden
            return $this->redirect()->toRoute('instruments');
        }
        if ($entity === false) { // Keine ID übergeben - neues Instrument anlegen
            $entity = new Instrument();
        }

        $form = new InstrumentForm($em);
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
                return $this->redirect()->toRoute('instruments');
            }
        }

        return array(
            'id'     => (int) $entity->id,
            'form'   => $form,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }
    
    public function lendAction()
    {
        $em = $this->getEntityManager();
        
        $entity = $this->getEntityFromRouteId('\Instruments\Entity\Instrument');
        if (!$entity) {
            return $this->redirect()->toRoute('instruments');
        }
        
        switch ($entity->status) {
            case Instrument::STATUS_IN_ARCHIVE:
                $form = new GiveAwayForm($em);
                $i2m = new Instrument2Member();
                $i2m->instrument = $entity;
                break;
            case Instrument::STATUS_GIVEN_AWAY:
                $form = new TakeBackForm($em);
                if (count($entity->instrument2members) == 0) {
                    throw new \Exception('Instrumenten-Status ist "Verliehen", aber es gibt keinen Verleih-Datensatz!');
                }
                $i2m = $entity->instrument2members[0];
                break;
            default:
                $form = null;
        }
        
        if ($form) {
            $form->bind($i2m);

            $request = $this->getRequest();

            if ($request->isPost()) {
                //$form->setInputFilter($entity->getInputFilter());
                $form->setData($request->getPost());

                if ($form->isValid()) {
                    $em->persist($i2m);

                    // Instrumenten-Status noch anpassen
                    if ($form instanceof GiveAwayForm) {
                        $entity->status = Instrument::STATUS_GIVEN_AWAY;
                    }
                    if ($form instanceof TakeBackForm) {
                        $entity->status = Instrument::STATUS_IN_ARCHIVE;
                    }
                    $em->flush();
                    return $this->redirect()->toRoute('instrumentEdit', array('id' => $entity->id));
                }
            }
        }
        
        return array(
            'id'         => $entity->id,
            'instrument' => $entity,
            'form'       => $form,
            'tabnav'     => $this->getTabnav($entity->id),
        );
    }
    
    public function repairAction()
    {
        $em = $this->getEntityManager();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$entity) {
            return $this->redirect()->toRoute('instruments');
        }
                
        $repair = new Repair();
        $repair->instrument = $entity;

        $form = new RepairForm($em);
        $form->bind($repair);

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($repair);
                $em->flush();
                return $this->redirect()->toRoute('instrumentRepair', array('id' => $entity->id));
            }
        }

        return array(
            'id'     => (int) $entity->id,
            'form'   => $form,
            'instrument' => $entity,
            'tabnav' => $this->getTabnav($entity->id),
        );
    }    

    public function deleteAction()
    {

    }
    
    protected function getTabnav($id = null)
    {
        $id = (int) $id;
        
        $config = array(
            array(
                'label' => 'Stammdaten',
                'route' => 'instrumentEdit',
                'params' => array(
                    'id' => $id
                ),
            ),
            array(
                'label' => 'Verleih',
                'route' => 'instrumentLend',
                'params' => array(
                    'id' => $id
                ),
                'visible' => $id != 0,
            ),
            array(
                'label' => 'Reparaturen',
                'route' => 'instrumentRepair',
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

