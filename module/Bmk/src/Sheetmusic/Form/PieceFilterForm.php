<?php

namespace Sheetmusic\Form;

use Application\Form\SessionForm;

use Doctrine\Common\Persistence\ObjectManager;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\InputFilter\InputFilterProviderInterface;

class PieceFilterForm extends SessionForm implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('piece-filter-form');
        
        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => 'Titel',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'composer-arranger',
            'type' => 'Text',
            'options' => array(
                'label' => 'Komponist, Arr.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'publisher',
            'type' => 'Text',
            'options' => array(
                'label' => 'Verlag',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'genre',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'object_manager' => $objectManager,
                'target_class' => 'Sheetmusic\Entity\Genre',
                'property' => 'name',
                'label' => 'Genre',
                'empty_option' => '',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'isAway',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Ausgelagert',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9 col-sm-push-3',
            )
        ));
        $this->add(array(
            'name' => 'isScanned',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Eingescanned',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9 col-sm-push-3',
            )
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
            'title' => array(
                'required' => false,
            ),
            'composer-arranger' => array(
                'required' => false,
            ),
            'publisher' => array(
                'required' => false,
            ),
            'genre' => array(
                'required' => false,
            ),
            'isAway' => array(
                'required' => false,
            ),
            'isScanned' => array(
                'required' => false,
            ),
        );
    }
    
}