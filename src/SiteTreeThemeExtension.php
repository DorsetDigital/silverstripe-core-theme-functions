<?php

namespace DorsetDigital\Themes\Derriford;

use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\View\HTML;

class SiteTreeThemeExtension extends SiteTreeExtension
{
    public function MetaTags(&$tags)
    {
        $themeTag = HTML::createTag('meta',
            ['author' => 'Derriford SilverStripe theme by Dorset Digital - https://dorset-digital.net']);
        $tags .= $themeTag;
    }
}