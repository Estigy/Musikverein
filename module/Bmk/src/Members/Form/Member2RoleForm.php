<?php

namespace Members\Form;

use Members\Entity\Member2Role;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Member2RoleForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('member2role-form');
        
        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Member2Role);
        
        $this->setAttribute('class', 'form-horizontal');
        
        $this->add(array(
            'name' => 'role',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Funktion',
                'object_manager' => $objectManager,
                'target_class' => 'Members\Entity\Role',
                'property' => 'name',
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'beginDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Eintritt',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'endDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Austritt',
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
            'role' => array(
                'required' => true,
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