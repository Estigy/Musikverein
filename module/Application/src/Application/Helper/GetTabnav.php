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
            $class = $item->getClass();
            $str .= '  <li role="presentation" class="' . $class . ($item->isActive() ? ' active' : '') . '">'
                 .  '<a href="' . $item->getHref() . '"' . ($item->getTarget() ? ' target="' . $item->getTarget() . '"' : '') . '>' . $item->label . '</a>'
                 .  '</li>';
        }
        $str .= '</ul>';

        return $str;
    }
} 
