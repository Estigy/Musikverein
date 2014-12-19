<?php

namespace Instruments\Form;

use Instruments\Entity\Instrument2Member;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class GiveAwayForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('giveaway-instrument-form');
        
        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Instrument2Member);
        
        $this->setAttribute('class', 'form-horizontal');
             
        $this->add(array(
            'name' => 'member',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Ausgabe an',
                'object_manager' => $objectManager,
                'target_class' => 'Members\Entity\Member',
                'label_generator' => function($entity) { return $entity->lastname . ' ' . $entity->firstname; },
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'giveAwayDate',
            'type' => 'Date',
            'options' => array(
                'label' => 'Datum',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->get('giveAwayDate')->setFormat('d.m.Y');
        $this->add(array(
            'name' => 'giveAwayMember',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Ausgebende Person',
                'object_manager' => $objectManager,
                'target_class' => 'Members\Entity\Member',
                'property_function' => 'name',
                'label_generator' => function($entity) { return $entity->lastname . ' ' . $entity->firstname; },
                'empty_option' => 'Bitte wählen...',
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
        ));
	}
    
    public function getInputFilterSpecification()
    {
        return array(
            'member' => array(
                'required' => true,
            ),
            'giveAwayDate' => array(
                'required' => true,
            ),
            'giveAwayMember' => array(
                'required' => true,
            ),
        );
    }
    
}