<?php
namespace DorsetDigital\Themes\Derriford\Extension;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements_Backend;
use SilverStripe\View\HTML;
use SilverStripe\Dev\Deprecation;

class CustomRequirements extends Requirements_Backend
{
    private function asyncCss()
    {
        $css = $this->getCSS();
        if (is_array($css)) {
            $tags = PHP_EOL;
            $nsTags = null;
            foreach (array_keys($css) as $cssFile) {
                $file = $this->pathForFile($cssFile);
                $tags .= $this->cssLinkTag($file);
                $nsTags .= $this->cssLink($file);
            }
            $tags .= $this->noscriptTag($nsTags);
            return $tags;
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

    public function includeInHTML($content)
    {
        if (func_num_args() > 1) {
            Deprecation::notice(
                '5.0',
                '$templateFile argument is deprecated. includeInHTML takes a sole $content parameter now.'
            );
            $content = func_get_arg(1);
        }

        // Skip if content isn't injectable, or there is nothing to inject
        $tagsAvailable = preg_match('#</head\b#', $content);
        $hasFiles = $this->css || $this->javascript || $this->customCSS || $this->customScript || $this->customHeadTags;
        if (!$tagsAvailable || !$hasFiles) {
            return $content;
        }
        $requirements = '';
        $jsRequirements = '';

        // Combine files - updates $this->javascript and $this->css
        $this->processCombinedFiles();

        // Script tags for js links
        foreach ($this->getJavascript() as $file => $attributes) {
            // Build html attributes
            $htmlAttributes = [
                'type' => isset($attributes['type']) ? $attributes['type'] : "application/javascript",
                'src' => $this->pathForFile($file),
            ];
            if (!empty($attributes['async'])) {
                $htmlAttributes['async'] = 'async';
            }
            if (!empty($attributes['defer'])) {
                $htmlAttributes['defer'] = 'defer';
            }
            $jsRequirements .= HTML::createTag('script', $htmlAttributes);
            $jsRequirements .= "\n";
        }

        // Add all inline JavaScript *after* including external files they might rely on
        foreach ($this->getCustomScripts() as $script) {
            $jsRequirements .= HTML::createTag(
                'script',
                [ 'type' => 'application/javascript' ],
                "//<![CDATA[\n{$script}\n//]]>"
            );
            $jsRequirements .= "\n";
        }

        // CSS file links
        $config = SiteConfig::current_site_config();
        if ($config->AsyncCSS == 1) {
         $requirements .= $this->asyncCss();
        }
        else {
            foreach ($this->getCSS() as $file => $params) {
                $htmlAttributes = [
                    'rel' => 'stylesheet',
                    'type' => 'text/css',
                    'href' => $this->pathForFile($file),
                ];
                if (!empty($params['media'])) {
                    $htmlAttributes['media'] = $params['media'];
                }
                $requirements .= HTML::createTag('link', $htmlAttributes);
                $requirements .= "\n";
            }
        }

        // Literal custom CSS content
        foreach ($this->getCustomCSS() as $css) {
            $requirements .= HTML::createTag('style', ['type' => 'text/css'], "\n{$css}\n");
            $requirements .= "\n";
        }

        foreach ($this->getCustomHeadTags() as $customHeadTag) {
            $requirements .= "{$customHeadTag}\n";
        }

        // Inject CSS  into body
        $content = $this->insertTagsIntoHead($requirements, $content);

        // Inject scripts
        if ($this->getForceJSToBottom()) {
            $content = $this->insertScriptsAtBottom($jsRequirements, $content);
        } elseif ($this->getWriteJavascriptToBody()) {
            $content = $this->insertScriptsIntoBody($jsRequirements, $content);
        } else {
            $content = $this->insertTagsIntoHead($jsRequirements, $content);
        }
        return $content;
    }


}