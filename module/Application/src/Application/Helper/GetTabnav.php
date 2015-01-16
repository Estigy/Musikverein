<?php

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

class GetTabnav extends AbstractHelper
{
    /**
     * Render template
     */
    public function __invoke($navigation)
    {
        $str = '<ul class="nav nav-tabs">';
        foreach ($navigation as $item) {
            if ($item->visible === false) {
                continue;
            }
            $str .= '  <li role="presentation"' . ($item->isActive() ? ' class="active"' : '') . '>'
                 .  '<a href="' . $item->getHref() . '">' . $item->label . '</a>'
                 .  '</li>';
        }
        $str .= '</ul>';

        return $str;
    }
} 
