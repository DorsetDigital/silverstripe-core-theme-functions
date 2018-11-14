<?php

namespace DorsetDigital\Themes\Derriford\Extension;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\ArrayData;

class PageExtension extends DataExtension
{

    private static $table_name = 'DD_PageExtension';

    private static $db = [
        'IncludeInFooterMenu' => 'Boolean(0)'
    ];

    public function getContainerClass()
    {
        $config = SiteConfig::current_site_config();
        if ($config->LimitWidth == 1) {
            return "container";
        }
        return "container-fluid";
    }

    public function updateSettingsFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Settings',
            CheckboxField::create('IncludeInFooterMenu')
                ->setTitle(_t(__CLASS__ . '.IncludeInFooter', 'Include in footer menu'))
            , 'ShowInSearch');
    }

    public function getFooterMenu()
    {
        return SiteTree::get()->filter(['IncludeInFooterMenu' => 1]);
    }

    public function getSocialLinks()
    {
        $social = ArrayList::create();
        $config = SiteConfig::current_site_config();
        if ($config->Facebook != "") {
            $social->push(ArrayData::create([
                'Link' => $config->Facebook,
                'Class' => 'fab fa-facebook'
            ]));
        }
        if ($config->Twitter != "") {
            $social->push(ArrayData::create([
                'Link' => $config->Twitter,
                'Class' => 'fab fa-twitter-square'
            ]));
        }

        if ($config->Instagram != "") {
            $social->push(ArrayData::create([
                'Link' => $config->Instagram,
                'Class' => 'fab fa-instagram'
            ]));
        }

        if ($config->LinkedIn != "") {
            $social->push(ArrayData::create([
                'Link' => $config->LinkedIn,
                'Class' => 'fab fa-linkedin'
            ]));
        }

        return $social;

    }


}