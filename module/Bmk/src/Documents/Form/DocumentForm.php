<?php

namespace Documents\Form;

use Documents\Entity\Document;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class DocumentForm extends Form implements InputFilterProviderInterface
{
    protected $hash = null;

	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('edit-piece-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Document);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'category',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Kategorie',
                'object_manager' => $objectManager,
                'target_class' => 'Documents\Entity\Category',
                'property' => 'name',
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'upload',
            'type' => 'File',
            'options' => array(
                'label' => 'Datei',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
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
            'name' => 'referenceDate',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Referenz-Datum',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
                'help-block' => 'zB Datum der Sitzung',
            ),
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
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'label' => 'Speichern',
            ),
        ));
	}

    public function getInputFilterSpecification()
    {
        return array(
            'category' => array(
                'required' => true,
            ),
            'upload' => array(
                'required' => $this->getObject()->id == null, // beim Bearbeiten muss es nicht enthalten sein
            ),
            'description' => array(
                'required' => true,
            ),
            'referenceDate' => array(
                'required' => false,
            ),
            'comment' => array(
                'required' => false,
            ),
        );
    }

}