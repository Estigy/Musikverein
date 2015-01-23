<?php

namespace Members\Form;

use Members\Entity\Member2Education;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Member2EducationForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('member2band-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Member2Education);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'register',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Instrument',
                'object_manager' => $objectManager,
                'target_class' => 'Bmk\Entity\Register',
                'find_method' => array(
                    'name' => 'findEntities',
                    'params' => array(
                    	'getForInstruments' => true
                    )
                ),
                'property' => 'name',
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'teacher',
            'type' => 'Text',
            'options' => array(
                'label' => 'Lehrer/in',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'group',
            'type' => 'Text',
            'options' => array(
                'label' => 'Gruppe',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        
        $this->add(array(
            'name' => 'beginDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Beginn',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'endDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Ende',
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
            'register' => array(
                'required' => true,
            ),
            'teacher' => array(
                'required' => false,
            ),
            'group' => array(
                'required' => false,
            ),
            'beginDate' => array(
                'required' => false,
            ),
            'endDate' => array(
                'required' => false,
            ),
        );
    }
}