<?php

namespace Application\Form\Element;

use Zend\Form\Element\Date;

class GermanDate extends Date
{
    protected $attributes = array(
        'type' => 'text',
        'data-type' => 'german-date',
    );

    protected $format = 'd.m.Y';
}