<?php

if (!function_exists('html')) {
    /**
     * @return Collective\Html\HtmlBuilder
     */
    function html()
    {
        return \Collective\Html\HtmlFacade::getFacadeRoot();
    }
}

if (!function_exists('form')) {
    /**
     * @return Collective\Html\FormBuilder
     */
    function form()
    {
        return \Collective\Html\FormFacade::getFacadeRoot();
    }
}
