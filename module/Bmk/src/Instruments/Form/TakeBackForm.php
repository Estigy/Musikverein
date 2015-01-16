<?php

namespace Instruments\Form;

use Instruments\Entity\Instrument2Member;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class TakeBackForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('takeback-instrument-form');
        
        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Instrument2Member);
        
        $this->setAttribute('class', 'form-horizontal');
             
        $this->add(array(
            'name' => 'takeBackDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Datum',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'takeBackMember',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Rücknehmende Person',
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
            'takeBackDate' => array(
                'required' => true,
            ),
            'takeBackMember' => array(
                'required' => true,
            ),
        );
    }
    
}