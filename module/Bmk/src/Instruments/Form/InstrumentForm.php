<?php

namespace Instruments\Form;

use Instruments\Entity\Instrument;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class InstrumentForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('edit-instrument-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Instrument);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'serialNumber',
            'type' => 'Text',
            'options' => array(
                'label' => 'Seriennummer',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'category',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'object_manager' => $objectManager,
                'target_class' => 'Instruments\Entity\Category',
                'property' => 'name',
                'label' => 'Kategorie',
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'brand',
            'type' => 'Text',
            'options' => array(
                'label' => 'Marke',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'variant',
            'type' => 'Text',
            'options' => array(
                'label' => 'Ausführung',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'buyDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Ankauf',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'outDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Ausgeschieden',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'insurance',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Versicherung',
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
            'serialNumber' => array(
                'required' => false,
            ),
            'category' => array(
                'required' => true,
            ),
            'brand' => array(
                'required' => false,
            ),
            'variant' => array(
                'required' => false,
            ),
            'buyDate' => array(
                'required' => false,
            ),
            'outDate' => array(
                'required' => false,
            ),
            'insurance' => array(
                'required' => false,
            ),
            'comment' => array(
                'required' => false,
            ),
        );
    }

}