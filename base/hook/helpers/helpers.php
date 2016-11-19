<?php

use WebEd\Base\Hook\Support\Facades\ActionsFacade;
use WebEd\Base\Hook\Support\Facades\FiltersFacade;

if (!function_exists('add_action')) {
    /**
     * @param string $hook
     * @param \Closure|string $callback
     * @param int $priority
     */
    function add_action($hook, $callback, $priority = 20)
    {
        ActionsFacade::addListener($hook, $callback, $priority);
    }
}

if (!function_exists('do_action')) {
    /**
     * Do an action
     * @param array ...$args
     */
    function do_action(...$args)
    {
        ActionsFacade::fire(array_shift($args), $args);
    }
}

if (!function_exists('add_filter')) {
    /**
     * @param string $hook
     * @param \Closure|string $callback
     * @param int $priority
     */
    function add_filter($hook, $callback, $priority = 20)
    {
        FiltersFacade::addListener($hook, $callback, $priority);
    }
}

if (!function_exists('do_filter')) {
    /**
     * @param array ...$args
     * @return mixed
     */
    function do_filter(...$args)
    {
        return FiltersFacade::fire(array_shift($args), $args);
    }
}
