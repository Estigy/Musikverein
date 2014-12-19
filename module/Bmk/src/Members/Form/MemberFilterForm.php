<?php

namespace Members\Form;

use Application\Form\SessionForm;

use Doctrine\Common\Persistence\ObjectManager;

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
            'namesearch' => array(
                'required' => false,
            ),
        );
    }
}