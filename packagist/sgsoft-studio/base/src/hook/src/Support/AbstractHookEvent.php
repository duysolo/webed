<?php namespace WebEd\Base\Hook\Support;

abstract class AbstractHookEvent
{
    /**
     * Stores the event listeners
     * @var array
     */
    protected $listeners = [];

    /**
     * Add a listener
     * @param string $hook Hook name
     * @param mixed $callback Function to execute
     * @param integer $priority Priority of the action
     * @author Tor Morten Jensen <tormorten@tormorten.no>
     */
    public function addListener($hook, $callback, $priority = 20)
    {
        $this->listeners[$priority][$hook] = compact('callback');
    }

    /**
     * Gets a sorted list of all listeners
     * @return array
     * @author Tor Morten Jensen <tormorten@tormorten.no>
     */
    public function getListeners()
    {
        /**
         * Sort by piority
         */
        uksort($this->listeners, function ($param1, $param2) {
            return strnatcmp($param1, $param2);
        });

        return $this->listeners;
    }

    /**
     * Get the function
     * @param $callback
     * @return \Closure|array|null|mixed
     * @author Tor Morten Jensen <tormorten@tormorten.no>
     */
    protected function getFunction($callback)
    {
        if (is_string($callback)) {
            if (strpos($callback, '@')) {
                $callback = explode('@', $callback);
                return [app('\\' . $callback[0]), $callback[1]];
            } else {
                return $callback;
            }
        } elseif ($callback instanceof \Closure) {
            return $callback;
        } elseif (is_array($callback) && sizeof($callback) > 1) {
            return [app('\\' . $callback[0]), $callback[1]];
        }
        return null;
    }

    /**
     * Fires a new action
     * @param string $action Name of action
     * @param array $args Arguments passed to the action
     * @author Tor Morten Jensen <tormorten@tormorten.no>
     */
    abstract function fire($action, array $args);
}
