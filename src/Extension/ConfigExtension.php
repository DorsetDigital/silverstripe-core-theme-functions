<?php

namespace DorsetDigital\Themes\Derriford\Extension;


use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use TractorCow\Colorpicker\Forms\ColorField;

class ConfigExtension extends DataExtension
{
    private static $db = [
        'CopyrightText' => 'Varchar(200)',
        'Telephone' => 'Varchar(50)',
        'Email' => 'Varchar(255)',
        'FooterText' => 'HTMLText',
        'ThemeCredits' => 'Boolean(1)',
        'Facebook' => 'Varchar(255)',
        'Twitter' => 'Varchar(255)',
        'Instagram' => 'Varchar(255)',
        'LinkedIn' => 'Varchar(255)',
        'MainBGColour' => 'Color',
        'MainTextColour' => 'Color',
        'MainNavColour' => 'Color',
        'InlineCriticalCSS' => 'Boolean(1)',
        'Address' => 'Text',
        'LimitWidth' => 'Boolean(1)'
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

    private static $defaults = [
        'InlineCriticalCSS' => 1,
        'ThemeCredits' => 1,
        'MainBGColour' => '#ffffff',
        'MainTextColour' => '#222222',
        'MainNavColour' => '#000000'
    ];

    public function updateCMSFields(FieldList $fields)
    {

        $fields->addFieldsToTab('Root.Logos', [
            UploadField::create('MainLogo')
                ->setFolderName('logos')
                ->setAllowedFileCategories('image/supported')
                ->setTitle(_t(__CLASS__ . '.MainLogo', 'Main logo')),
            UploadField::create('MobileLogo')
                ->setFolderName('logos')
                ->setAllowedFileCategories('image/supported')
                ->setTitle(_t(__CLASS__ . '.MobileLogo', 'Mobile logo'))
                ->setDescription(_t(__CLASS__ . '.MobileLogoDescription',
                    'Alternative logo for small devices - leave blank to use only the main logo')),
            UploadField::create('FooterLogo')
                ->setFolderName('logos')
                ->setAllowedFileCategories('image/supported')
                ->setTitle(_t(__CLASS__ . '.FooterLogo', 'Footer logo'))
        ]);

        $fields->addFieldsToTab('Root.ContactInfo', [
            TextareaField::create('Address')
                ->setTitle(_t(__CLASS__ . '.Address', 'Address'))
                ->setDescription(_t(__CLASS__ . '.AddressDescription',
                    'Shown at the bottom of the site and on the contact page')),
            TextField::create('Telephone')
                ->setTitle(_t(__CLASS__ . '.Telephone', 'Telephone')),
            EmailField::create('Email')
                ->setTitle(_t(__CLASS__ . '.Email', 'Email Address')),
            TextField::create('Facebook')
                ->setTitle(_t(__CLASS__ . '.Facebook', 'Facebook Page'))
                ->setDescription(_t(__CLASS__ . '.FacebookDescription',
                    "Full URL for the Facebook page, including the 'https://' part")),
            TextField::create('Twitter')
                ->setTitle(_t(__CLASS__ . '.Twitter', 'Twitter Page'))
                ->setDescription(_t(__CLASS__ . '.TwitterDescription',
                    "Full URL for the Twitter page, including the 'https://' part")),
            TextField::create('Instagram')
                ->setTitle(_t(__CLASS__ . '.Instagram', 'Instagram Page'))
                ->setDescription(_t(__CLASS__ . '.InstagramDescription',
                    "Full URL for the Instagram page, including the 'https://' part")),
            TextField::create('LinkedIn')
                ->setTitle(_t(__CLASS__ . '.LinkedIn', 'Linked Page'))
                ->setDescription(_t(__CLASS__ . '.LinkedInDescription',
                    "Full URL for the LinkedIn page, including the 'https://' part")),
        ]);

        $fields->addFieldsToTab('Root.ThemeText', [
            TextField::create('CopyrightText')
                ->setTitle(_t(__CLASS__ . '.CopyrightText', 'Copyright Text'))
                ->setDescription(_t(__CLASS__ . '.CopyrightTextDescription', 'Text shown after the copyright date')),
            HTMLEditorField::create('FooterText')
                ->setTitle(_t(__CLASS__ . '.FooterText', 'Footer Text'))
                ->setDescription(_t(__CLASS__ . '.FooterTextDescription',
                    'Text shown in the footer.  Useful for legal information, etc.'))
        ]);

        $fields->addFieldsToTab('Root.ThemeColours', [
            ColorField::create('MainBGColour')
                ->setTitle(_t(__CLASS__ . '.MainBGColour', 'Site main background colour')),
            ColorField::create('MainTextColour')
                ->setTitle(_t(__CLASS__ . '.MainTextColour', 'Site primary text colour')),
            ColorField::create('MainNavColour')
                ->setTitle(_t(__CLASS__ . '.MainNavColour', 'Site main nav text colour'))
        ]);

        $fields->addFieldsToTab('Root.ThemeSettings', [
            CheckboxField::create('InlineCriticalCSS')
                ->setTitle(_t(__CLASS__ . '.InlineCSS', 'Inline Critical CSS'))
                ->setDescription(_t(__CLASS__ . '.InlineCSSDescription',
                    'Temporarily inline critical CSS to improve page rendering performance until the browser caches it')),
            CheckboxField::create('ThemeCredits')
                ->setTitle(_t(__CLASS__ . '.ThemeCredits', 'Show Theme Credits'))
                ->setDescription(_t(__CLASS__ . '.ThemeCreditsDescription',
                    'Show a small theme credit at the bottom of the page.  Please consider leaving this active if you use the theme!')),
            CheckboxField::create('LimitWidth')
                ->setTitle(_t(__CLASS__ . '.LimitWidth', 'Constraint Content Width'))
                ->setDescription(_t(__CLASS__ . '.LimitWidthDescription',
                    'Limit the content width to a maximum of 1410px.  Uncheck to allow content to expand to fill any screen width.'))
        ]);
    }
}