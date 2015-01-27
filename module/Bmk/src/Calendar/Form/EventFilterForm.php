<?php

namespace Calendar\Form;

use Application\Factory\ServiceLocatorFactory;
use Application\Form\SessionForm;

use Bmk\Service\BandService;

use Calendar\Entity\Event;

use Doctrine\Common\Persistence\ObjectManager;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\InputFilter\InputFilterProviderInterface;

class EventFilterForm extends SessionForm implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('event-filter-form');
        
        $this->setAttribute('class', 'form-horizontal');
        
        $maxDate = date('Y') + 2;
        $yearOptions = array();
        for ($i = 2006; $i <= $maxDate; $i++) {
            $yearOptions[$i] = $i;
        }

        $this->add(array(
            'name' => 'year',
            'type' => 'Select',
            'options' => array(
                'label' => 'Jahr',
                'value_options' => $yearOptions,
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
                'value_options' => Event::getStati(),
                'empty_option' => '',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'type',
            'type' => 'Select',
            'options' => array(
                'label' => 'Typ',
                'value_options' => Event::getTypes(),
                'empty_option' => '',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'band',
            'type' => 'Select',
            'options' => array(
                'label' => 'Kapelle',
                'value_options' => ServiceLocatorFactory::getInstance()->get('BandService')->getBands(),
                'empty_option' => '',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Filtern',
                'id' => 'filterbutton',
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9 col-sm-push-3',
            )
        ));
        
    }
    
    public function getInputFilterSpecification()
    {
        return array(
            'year' => array(
                'required' => true,
            ),
            'status' => array(
                'required' => false,
            ),
            'type' => array(
                'required' => false,
            ),
            'band' => array(
                'required' => false,
            ),
        );
    }
    
    protected function getDefaultData()
    {
        $data = parent::getDefaultData();
        
        $data['year'] = date('Y');
        
        return $data;
    }
}