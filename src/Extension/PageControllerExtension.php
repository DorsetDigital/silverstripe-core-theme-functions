<?php

namespace DorsetDigital\Themes\Derriford\Extension;

use DorsetDigital\SilverstripeRequirements\RequirementsInline;
use SilverStripe\Core\Extension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;

class PageControllerExtension extends Extension
{
    public function onAfterInit()
    {
        RequirementsInline::themedCSS('client/dist/css/critical');
        Requirements::customCSS($this->getThemeCSS());
        Requirements::css('https://use.fontawesome.com/releases/v5.5.0/css/all.css');
        Requirements::themedCSS('client/dist/css/common');

        RequirementsInline::themedJavascript('client/dist/javascript/thirdparty/filament/cssrelpreload.js');
        Requirements::javascript('https://code.jquery.com/jquery-3.3.1.min.js', ['defer' => 'true']);

        $path = ThemeResourceLoader::inst()->findThemedJavascript('client/dist/javascript/site.min', SSViewer::get_themes());

        Requirements::javascript($path, ['defer' => 'true']);
    }

    private function getThemeCSS()
    {
        $config = SiteConfig::current_site_config();
        $bgcolour = $config->MainBGColour;
        $textcolour = $config->MainTextColour;
        $navcolour = $config->MainNavColour;

        $css = $this->createCSSTag('html,body', [
                'background-color' => '#'.$bgcolour,
                'font-color' => '#'.$textcolour
            ]
        );

        $css .= $this->createCSSTag('nav-item', 'color:#'.$navcolour);

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