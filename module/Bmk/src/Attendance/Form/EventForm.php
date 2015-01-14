<?php

namespace Attendance\Form;

use Attendance\Entity\Event;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class EventForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('edit-attendance-event-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Event);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'date',
            'type' => 'Date',
            'options' => array(
                'label' => 'Datum',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
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
                'value' => 'Speichern',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
	}

    public function getInputFilterSpecification()
    {
        return array(
            'date' => array(
                'required' => true,
            ),
            'name' => array(
                'required' => false,
            ),
        );
    }

}