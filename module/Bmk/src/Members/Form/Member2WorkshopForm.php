<?php

namespace Members\Form;

use Members\Entity\Member2Workshop;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Member2WorkshopForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('workshop2member-form');
        
        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Member2Workshop);
        
        $this->setAttribute('class', 'form-horizontal');
             
        $this->add(array(
            'name' => 'workshop',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Kurs',
                'object_manager' => $objectManager,
                'target_class' => 'Members\Entity\Workshop',
                'label_generator' => function($entity) {
                		return $entity->name
                		     . ' ('
                		     . $entity->beginDate->format('d.m.Y.')
                		     . ($entity->endDate ? ' - ' . $entity->endDate->format('d.m.Y.') : '')
                		     . ')';
                },
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'infos',
            'type' => 'Text',
            'options' => array(
                'label' => 'Zusatz-Infos',
                'help-block' => 'zB. Instrument',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Speichern',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9 col-sm-push-3',
            ),
        ));
	}
    
    public function getInputFilterSpecification()
    {
        return array(
            'workshop' => array(
                'required' => true,
            ),
            'infos' => array(
                'required' => false,
            ),
        );
    }
}