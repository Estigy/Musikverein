<?php

namespace Members\Form;

use Members\Entity\Member2Band;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

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
        
        $bandOptions = array(
            'BMK' => 'BMK',
            'JK'  => 'JK',
            'NWK' => 'NWK',
        );
        
        $this->add(array(
            'name' => 'band',
            'type' => 'Select',
            'options' => array(
                'label' => 'Orchester',
                'value_options' => $bandOptions,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'beginDate',
            'type' => 'Date',
            'options' => array(
                'label' => 'Eintritt',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->get('beginDate')->setFormat('d.m.Y');
        $this->add(array(
            'name' => 'endDate',
            'type' => 'Date',
            'options' => array(
                'label' => 'Austritt',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->get('endDate')->setFormat('d.m.Y');

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
            'band' => array(
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