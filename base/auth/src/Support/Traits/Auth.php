<?php namespace WebEd\Base\Auth\Support\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

trait Auth
{
    use AuthenticatesUsers;

    //Don't allow login attempts after failed {x} times
    protected $maxLoginAttempts = 10;

    //1 hour
    protected $lockoutTime = 60;

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        $credentials['status'] = 'activated';

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (!$lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        \FlashMessages::addMessages([
            $this->getFailedLoginMessage(),
        ], 'danger')
            ->showMessagesOnSession();


        return $this->sendFailedLoginResponse($request);
    }

    public function authenticated($request, $user)
    {
        return redirect()->to($this->redirectTo);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        $failedMessage = $this->module . '::auth.failed';
        return \Lang::has($failedMessage)
            ? \Lang::get($failedMessage)
            : 'These credentials do not match our records!!!';
    }

    public function username()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
}
