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
            'name' => 'beginYear',
            'type' => 'Number',
            'options' => array(
                'label' => 'Beginn',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'endYear',
            'type' => 'Number',
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
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'label' => 'Speichern',
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
            'beginYear' => array(
                'required' => false,
            ),
            'endYear' => array(
                'required' => false,
            ),
        );
    }
}