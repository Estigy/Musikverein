<?php

namespace Instruments\Form;

use Application\Form\SessionForm;

use Instruments\Entity\Instrument;

use Doctrine\Common\Persistence\ObjectManager;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\InputFilter\InputFilterProviderInterface;

class InstrumentFilterForm extends SessionForm implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('instrument-filter-form');
        
        $this->setAttribute('class', 'form-horizontal');
        
        $statusOptions = array(
            'active' => 'aktive (Archiv + verliehen)',
            Instrument::STATUS_GIVEN_AWAY => 'verliehen',
            Instrument::STATUS_IN_ARCHIVE => 'im Archiv',
            Instrument::STATUS_INACTIVE   => 'ausgeschieden',
        );

        $this->add(array(
            'name' => 'serialsearch',
            'type' => 'Text',
            'options' => array(
                'label' => 'Seriennummer',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'status',
            'type' => 'Select',
            'options' => array(
                'label' => 'Status',
                'value_options' => $statusOptions,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'id' => 'filterbutton',
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'label' => 'Filtern',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9 col-sm-push-3',
            )
        ));
    }
    
    public function getInputFilterSpecification()
    {
        return array(
            'serialsearch' => array(
                'required' => false,
            ),
            'status' => array(
                'required' => false,
            ),
        );
    }
    
}