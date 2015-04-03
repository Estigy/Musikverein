<?php

namespace Documents\Form;

use Application\Form\SessionForm;

use Doctrine\Common\Persistence\ObjectManager;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\InputFilter\InputFilterProviderInterface;

class DocumentFilterForm extends SessionForm implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('piece-filter-form');
        
        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'description',
            'type' => 'Text',
            'options' => array(
                'label' => 'Beschreibung',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'category',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Kategorie',
                'object_manager' => $objectManager,
                'target_class' => 'Documents\Entity\Category',
                'property' => 'name',
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
            'description' => array(
                'required' => false,
            ),
            'category' => array(
                'required' => false,
            ),
        );
    }
    
}