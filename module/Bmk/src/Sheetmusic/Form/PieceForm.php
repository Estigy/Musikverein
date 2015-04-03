<?php

namespace Sheetmusic\Form;

use Sheetmusic\Entity\Piece;

use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class PieceForm extends Form implements InputFilterProviderInterface
{
	public function __construct(ObjectManager $objectManager)
	{
		parent::__construct('edit-piece-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Piece);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => 'Title',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'composer',
            'type' => 'Text',
            'options' => array(
                'label' => 'Komponist',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'arranger',
            'type' => 'Text',
            'options' => array(
                'label' => 'Bearbeiter',
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
            'name' => 'year',
            'type' => 'Text',
            'options' => array(
                'label' => 'Jahr',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-3',
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
                'empty_option' => 'Bitte wählen...',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'archivedAt',
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'object_manager' => $objectManager,
                'target_class' => 'Sheetmusic\Entity\Piece',
                'label_generator' => function($entity) { return $entity->title . ' (' . $entity->id . ')'; },
                'find_method' => array(
                    'name' => 'findEntities',
                    'params' => array(
                        'filters' => array('order' => 'title')
                    )
                ),
                'label' => 'Archiviert unter',
                'empty_option' => 'Bitte wählen...',
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
            'name' => 'isUnusable',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Unbrauchbar',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9 col-sm-push-3',
                'help-block' => 'Bitte Grund unbedingt im Kommentarfeld angeben',
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
            'title' => array(
                'required' => true,
            ),
            'composer' => array(
                'required' => false,
            ),
            'arranger' => array(
                'required' => false,
            ),
            'publisher' => array(
                'required' => false,
            ),
            'year' => array(
                'required' => false,
            ),
            'genre' => array(
                'required' => false,
            ),
            'archivedAt' => array(
                'required' => false,
            ),
            'isAway' => array(
                'required' => false,
            ),
            'isScanned' => array(
                'required' => false,
            ),
            'isUnusable' => array(
                'required' => false,
            ),
            'comment' => array(
                'required' => false,
            ),
        );
    }

}
