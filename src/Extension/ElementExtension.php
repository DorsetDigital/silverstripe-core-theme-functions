<?php

namespace DorsetDigital\Themes\Core\Extension;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use TractorCow\Colorpicker\Forms\ColorField;

class ElementExtension extends DataExtension
{

    private static $db = [
        'ElementConstrainWidth' => 'Boolean',
        'ElementBackgroundColour' => 'Color',
        'PadElement' => 'Boolean'
    ];

    private static $defaults = [
        'PadElement' => 1,
        'ElementConstrainWidth' => 1
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Settings', [
            CheckboxField::create('ElementConstrainWidth')
                ->setTitle(_t(__CLASS__ . '.ConstrainWidth', 'Constraint width'))
                ->setDescription(_t(__CLASS__ . '.ConstrainWidthDesc',
                    'Constrain the width of this element\'s content, even if the theme is set in \'full width\' mode')),
            ColorField::create('ElementBackgroundColour')
                ->setTitle(_t(__CLASS__ . '.BackgroundColour', 'Background Colour'))
                ->setDescription(_t(__CLASS__ . '.BackgroundColourDesc',
                    'Background colour of this element\'s container')),
            CheckboxField::create('PadElement')
                ->setTitle(_t(__CLASS__ . '.PadElement', 'Add padding to the element'))
        ]);
        parent::updateCMSFields($fields);
    }
}