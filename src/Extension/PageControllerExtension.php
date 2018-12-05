<?php

namespace DorsetDigital\Themes\Derriford\Extension;

use DorsetDigital\SilverstripeRequirements\RequirementsInline;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;
use SilverStripe\Control\Director;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Manifest\ResourceURLGenerator;

class PageControllerExtension extends Extension
{
    public function onAfterInit()
    {
        $siteConfig = SiteConfig::current_site_config();
        if ($siteConfig->InlineCriticalCSS == 1) {
            RequirementsInline::themedCSS('client/dist/css/critical', __CLASS__.'criticalcss');
        } else {
            Requirements::themedCSS('client/dist/css/critical');
        }
        Requirements::customCSS($this->getThemeCSS(), __CLASS__.'themecss');

        Requirements::css('https://use.fontawesome.com/releases/v5.5.0/css/all.css');
        Requirements::themedCSS('client/dist/css/common');

        RequirementsInline::themedJavascript('client/dist/javascript/thirdparty/filament/cssrelpreload.js', __CLASS__.'preloadjs');
        Requirements::javascript('https://code.jquery.com/jquery-3.3.1.min.js');

        $path = ThemeResourceLoader::inst()->findThemedJavascript('client/dist/javascript/site.min',
            SSViewer::get_themes());

        Requirements::javascript($path, ['defer' => 'true']);

        Requirements::block('silverstripe/elemental-bannerblock:client/dist/styles/frontend-default.css');
    }

    private function getThemeCSS()
    {
        $config = SiteConfig::current_site_config();
        $bgcolour = $config->MainBGColour;
        $textcolour = $config->MainTextColour;
        $navcolour = $config->MainNavColour;
        $headerBG = $config->HeaderBGColour;
        $highlightColour1 = $config->HighlightColour1;

        $css = $this->createCSSTag('html,body', [
                'background-color' => '#' . $bgcolour,
                'font-color' => '#' . $textcolour
            ]
        );

        $css .= $this->createCSSTag('.nav-item', 'color:#' . $navcolour);
        $css .= $this->createCSSTag('header', 'background-color:#' . $headerBG);
        $css .= $this->createCSSTag('.bg-highlight1', 'background-color:#' . $highlightColour1);

        return $css;
    }


    private function createCSSTag($element, $rules)
    {
        if (is_array($rules)) {
            $style = null;
            foreach ($rules as $attribute => $value) {
                $style .= $attribute . ':' . $value . ';';
            }
        } else {
            $style = str_replace(["\r", "\n"], '', $rules);
        }
        $tag = $element . '{' . $style . '}';
        return $tag;
    }

}