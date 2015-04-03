<?php

namespace Members\Form;

use Application\Factory\ServiceLocatorFactory;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use Members\Entity\Member2Band;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Member2BandForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('member2band-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Member2Band);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'band',
            'type' => 'Select',
            'options' => array(
                'label' => 'Orchester',
                'value_options' => ServiceLocatorFactory::getInstance()->get('BandService')->getBands(),
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'register',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Register',
                'object_manager' => $objectManager,
                'target_class' => 'Bmk\Entity\Register',
                'find_method' => array(
                    'name' => 'findEntities',
                    'params' => array(
                        'filters' => array('getForAttendance' => 1),
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
            'band' => array(
                'required' => true,
            ),
            'register' => array(
                'required' => false,
            ),
            'beginDate' => array(
                'required' => true,
            ),
            'endDate' => array(
                'required' => false,
            ),
        );
    }
}