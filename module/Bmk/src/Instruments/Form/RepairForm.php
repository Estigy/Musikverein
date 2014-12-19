<?php

namespace Instruments\Form;

use Instruments\Entity\Instrument2Member;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class RepairForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('giveaway-instrument-form');
        
        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Instrument2Member);
        
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
        $this->get('date')->setFormat('d.m.Y');
        $this->add(array(
            'name' => 'company',
            'type' => 'Text',
            'options' => array(
                'label' => 'Firma, Werkstatt',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Beschreibung',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            )
        ));
        $this->add(array(
            'name' => 'comment',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Kommentar',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            )
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
            'company' => array(
                'required' => true,
            ),
            'description' => array(
                'required' => false,
            ),
            'comment' => array(
                'required' => false,
            ),
        );
    }
    
}