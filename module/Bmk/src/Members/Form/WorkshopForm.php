<?php

namespace Members\Form;

use Members\Entity\Workshop;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class WorkshopForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('edit-workshop-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Workshop);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
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
            ),
        ));
	}

    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            ),
        );
    }

}