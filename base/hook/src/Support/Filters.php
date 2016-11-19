<?php namespace WebEd\Base\Hook\Support;

class Filters extends AbstractHookEvent
{
    /**
     * Filters a value
     * @param  string $action Name of filter
     * @param  array $args Arguments passed to the filter
     * @return string Always returns the value
     * @author Tor Morten Jensen <tormorten@tormorten.no>
     */
    public function fire($action, array $args)
    {
        $value = isset($args[0]) ? $args[0] : ''; // get the value, the first argument is always the value
        if ($this->getListeners()) { // only run if listeners are set
            foreach ($this->getListeners() as $priority => $listeners) { // go through each of the priorities
                foreach ($listeners as $hook => $arguments) { // loop all hooks
                    if ($hook === $action) { // if the hook responds to the current filter
                        // filter the value
                        $value = call_user_func_array($this->getFunction($arguments['callback']), $args);
                    }
                }
            }
        }
        return $value; // return the value
    }
}
