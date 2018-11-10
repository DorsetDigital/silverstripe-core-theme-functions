<?php

namespace DorsetDigital\Themes\Derriford;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;

class ConfigExtension extends DataExtension
{
    private static $db = [
        'CopyrightText' => 'Varchar(200)',
        'Telephone' => 'Varchar(50)',
        'Email' => 'Varchar(255)'
    ];

    private static $many_many = [
        'MainLogo' => Image::class,
        'MobileLogo' => Image::class,
        'FooterLogo' => Image::class
    ];

    private static $owns = [
        'MainLogo',
        'MobileLogo',
        'FooterLogo'
    ];
}