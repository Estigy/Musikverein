<?php

namespace Attendance\Form;

use Attendance\Entity\Sheet;

use Application\Factory\ServiceLocatorFactory;

use Calendar\Entity\Event as CalendarEvent;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class SheetForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('edit-attendance-list-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Sheet);

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
            'name' => 'band',
            'type' => 'Radio',
            'options' => array(
                'value_options' => ServiceLocatorFactory::getInstance()->get('BandService')->getBands(),
                'label' => 'Orchester',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'year',
            'type' => 'Number',
            'options' => array(
                'label' => 'Jahr',
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
            'name' => array(
                'required' => true,
            ),
            'band' => array(
                'required' => true,
            ),
        );
    }

}