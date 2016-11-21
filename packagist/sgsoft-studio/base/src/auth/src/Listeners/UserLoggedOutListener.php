<?php

namespace WebEd\Base\Auth\Listeners;

use Illuminate\Auth\Events\Logout;

class UserLoggedOutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $event;

    /**
     * Handle the event.
     *
     * @param  Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $this->event = $event;

        session(['lastLoggedIn' => null]);
    }
}
