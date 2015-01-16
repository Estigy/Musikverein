<?php

namespace Members\Form;

use Members\Entity\Member2Medal;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Member2MedalForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('member2medal-form');
        
        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Member2Medal);
        
        $this->setAttribute('class', 'form-horizontal');
             
        $this->add(array(
            'name' => 'medal',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Abzeichen',
                'object_manager' => $objectManager,
                'target_class' => 'Members\Entity\Medal',
                'property' => 'name',
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'date',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Datum',
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
                'help-block' => 'zB. Instrument, Anlass etc.',
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
            'medal' => array(
                'required' => true,
            ),
            'date' => array(
                'required' => false,
            ),
            'infos' => array(
                'required' => false,
            ),
            'genre' => array(
                'required' => false,
            ),
        );
    }
}