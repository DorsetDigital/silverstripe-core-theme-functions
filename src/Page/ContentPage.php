<?php
namespace DorsetDigital\Themes\Core\Page;

use DorsetDigital\Themes\Core\Controller\ContentPageController;

class ContentPage extends \Page
{
    private static $table_name = 'DD_ContentPage';
    private static $hide_ancestor = \Page::class;
}