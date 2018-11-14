<?php

namespace DorsetDigital\Themes\Derriford\Extension;

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
            ['author' => 'Derriford SilverStripe theme by Dorset Digital - https://dorset-digital.net']
        );
        $tags .= PHP_EOL . $themeTag;

        $config = SiteConfig::current_site_config();
        if ($config->InlineCriticalCSS == 1) {
            $tags .= $this->asyncCss();
        }
    }


    private function asyncCss()
    {
        $css = Requirements::backend()->getCSS();
        if (is_array($css)) {
            $tags = PHP_EOL;
            $nsTags = null;
            $backend = Requirements::backend();
            foreach (array_keys($css) as $cssFile) {
                Requirements::block($cssFile);
                $file = $this->pathForFile($cssFile);
                $tags .= $this->cssLinkTag($file);
                $nsTags .= $this->cssLink($file);
            }
            $tags .= $this->noscriptTag($nsTags);
            return $tags;
        }
    }

    protected function pathForFile($fileOrUrl)
    {
        // Since combined urls could be root relative, treat them as urls here.
        if (preg_match('{^(//)|(http[s]?:)}', $fileOrUrl) || Director::is_root_relative_url($fileOrUrl)) {
            return $fileOrUrl;
        } else {
            return Injector::inst()->get(ResourceURLGenerator::class)->urlForResource($fileOrUrl);
        }
    }

    protected function cssLinkTag($file)
    {
        $tpl = '<link rel="preload" href="%s" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . PHP_EOL;
        return sprintf($tpl, $file);
    }

    protected function cssLink($file)
    {
        $tpl = '<link rel="stylesheet" href="%s">' . PHP_EOL;
        return sprintf($tpl, $file);
    }

    protected function noscriptTag($content)
    {
        $tpl = '<noscript>' . PHP_EOL . '%s</noscript>';
        return sprintf($tpl, $content);
    }




}