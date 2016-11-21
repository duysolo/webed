<?php namespace WebEd\Base\Hook\Support;

class Actions extends AbstractHookEvent
{
    /**
     * Filter a value
     * @param  string $action Name of action
     * @param  array $args Arguments passed to the filter
     * @author Tor Morten Jensen <tormorten@tormorten.no>
     */
    public function fire($action, array $args)
    {
        if ($this->getListeners()) {
            foreach ($this->getListeners() as $priority => $listeners) {
                foreach ($listeners as $hook => $arguments) {
                    if ($hook === $action) {
                        call_user_func_array($this->getFunction($arguments['callback']), $args);
                    }
                }
            }
        }
    }
}
