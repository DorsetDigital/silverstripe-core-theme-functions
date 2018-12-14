<?php

namespace DorsetDigital\Themes\Core\Extension;

use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Director;
use SilverStripe\Core\Manifest\ResourceURLGenerator;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\View\HTML;
use SilverStripe\Control\HTTPRequest;


class SiteTreeThemeExtension extends SiteTreeExtension
{

    public function MetaTags(&$tags)
    {
        $themeTag = HTML::createTag('meta',
            [
                'name' => 'author',
                'content' => 'SilverStripe theme by Dorset Digital - https://dorset-digital.net'
            ]
        );
        $tags .= PHP_EOL . $themeTag;
    }
}