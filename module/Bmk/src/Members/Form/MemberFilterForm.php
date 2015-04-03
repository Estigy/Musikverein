<?php

namespace Members\Form;

use Application\Form\SessionForm;

use Doctrine\Common\Persistence\ObjectManager;

use Members\Entity\Member;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface;

class MemberFilterForm extends SessionForm implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('member-filter-form');
        
        $this->setAttribute('class', 'form-horizontal');
        
        $this->add(array(
            'name' => 'namesearch',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'status',
            'type' => 'Select',
            'options' => array(
                'value_options' => Member::getStati(),
                'label' => 'Status',
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
            'namesearch' => array(
                'required' => false,
            ),
            'status' => array(
                'required' => false,
            ),
        );
    }
    
    protected function getDefaultData()
    {
        $data = parent::getDefaultData();
        
        $data['status'] = Member::STATUS_AKTIV;
        
        return $data;
    }
}