<?php

namespace Rts;

class View
{
    public function render($template, array $vars)
    {
        extract($vars);
        ob_start();
        require $template;
        return ob_get_clean();
    }
}