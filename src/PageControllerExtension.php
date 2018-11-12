<?php

namespace DorsetDigital\Themes\Derriford;

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class PageControllerExtension extends Extension
{
    public function onAfterInit()
    {
        return true;
        Requirements::javascript('https://code.jquery.com/jquery-3.3.1.min.js');
        Requirements::javascript(ThemeResourceLoader::inst()->findThemedJavascript('thirdparty/fontawesome/all.min'),
            ['async' => true, 'defer' => true]);
        Requirements::css('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700');

        $commonScripts = [
            ThemeResourceLoader::inst()->findThemedJavascript('thirdparty/bootstrap/util'),
            ThemeResourceLoader::inst()->findThemedJavascript('thirdparty/bootstrap/collapse'),
            ThemeResourceLoader::inst()->findThemedJavascript('thirdparty/bootstrap/dropdown'),
            ThemeResourceLoader::inst()->findThemedJavascript('thirdparty/bootstrap/carousel'),
        ];

        Requirements::combine_files('scripts.js', $commonScripts, ['async' => true]);
    }





}