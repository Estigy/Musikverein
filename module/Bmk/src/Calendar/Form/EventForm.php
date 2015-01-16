<?php

namespace Calendar\Form;

use Calendar\Entity\Event;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use TwbBundle\Form\View\Helper\TwbBundleForm;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class EventForm extends Form implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('edit-event-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, false))->setObject(new Event);

        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'date',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Datum',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'dateTo',
            'type' => 'Application\Form\Element\GermanDate',
            'options' => array(
                'label' => 'Datum bis',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'beginTime',
            'type' => 'Time',
            'options' => array(
                'label' => 'Beginnzeit',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
                'format' => 'H:i',
            ),
        ));
        $this->add(array(
            'name' => 'appointmentTime',
            'type' => 'Time',
            'options' => array(
                'label' => 'Treffpunkt',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
                'format' => 'H:i',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'city',
            'type' => 'Text',
            'options' => array(
                'label' => 'Ort',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'location',
            'type' => 'Text',
            'options' => array(
                'label' => 'Location',
                'help-block' => 'Lokalität',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'type',
            'type' => 'Radio',
            'options' => array(
                'value_options' => Event::getTypes(),
                'label' => 'Typ',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'band',
            'type' => 'MultiCheckbox',
            'options' => array(
                'value_options' => Event::getBands(),
                'label' => 'Wer',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'status',
            'type' => 'Radio',
            'options' => array(
                'value_options' => Event::getStati(),
                'label' => 'Status',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            ),
        ));
        $this->add(array(
            'name' => 'comment',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Kommentar',
                'help-block' => 'Anfahrt, Stücke, etc.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-9',
                'label_attributes' => array('class' => 'col-sm-3'),
            )
        ));
        $this->add(array(
            'name' => 'showOnHomepage',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Auf Homepage anzeigen',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-12',
            )
        ));
        $this->add(array(
            'name' => 'homepageText',
            'type' => 'Textarea',
            'options' => array(
                'help-block' => 'Zusätzlicher Text für Homepage (optional)',
                'column-size' => 'sm-12',

            )
        ));
        $this->add(array(
            'name' => 'showInBoard',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Im Board anzeigen',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-12',
            )
        ));
        $this->add(array(
            'name' => 'boardText',
            'type' => 'Textarea',
            'options' => array(
                'help-block' => 'Zusätzlicher Text fürs Board (optional)',
                'column-size' => 'sm-12',
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
            'name' => array(
                'required' => true,
            ),
            'date' => array(
                'required' => true,
            ),
            'dateTo' => array(
                'required' => false,
            ),
            'beginTime' => array(
                'required' => false,
            ),
            'appointmentTime' => array(
                'required' => false,
            ),
            'band' => array(
                'required' => false,
            ),
        );
    }

}