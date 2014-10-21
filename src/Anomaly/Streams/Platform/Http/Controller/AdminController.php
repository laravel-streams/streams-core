<?php namespace Anomaly\Streams\Platform\Http\Controller;

class AdminController extends BaseController
{
    /**
     * Display the admin login page.
     */
    public function login()
    {
        return view('theme::login');
    }

    /**
     * Attempt to login.
     *
     * @return mixed
     */
    public function attemptLogin()
    {
        $auth     = app('auth');
        $events   = app('events');
        $request  = app('request');
        $redirect = app('redirect');

        $messages = app('streams.messages');

        try {
            $credentials = [
                'email'    => $request->get('email'),
                'password' => $request->get('password'),
            ];

            // Let an event try and handle authenticating a login.
            if ($return = $events->fire('user.authenticate', $credentials)) {
                return $redirect->intended($return);
            }

            $user = $auth->authenticate($credentials, $request->get('remember'));

            $events->fire('user.login', $user);

            $messages->add('info', 'Welcome, ' . $user->name . '.')->flash();

            return $redirect->intended('admin/dashboard');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $messages->add('error', 'Login field is required.')->flash();
            return $redirect->to('admin/login');
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $messages->add('error', 'Password field is required.')->flash();
            return $redirect->to('admin/login');
        } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $messages->add('error', 'Wrong password, try again.')->flash();
            return $redirect->to('admin/login');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $messages->add('error', 'User was not found.')->flash();
            return $redirect->to('admin/login');
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $messages->add('error', 'User is not activated.')->flash();
            return $redirect->to('admin/login');
        } catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $messages->add('error', 'User is suspended.')->flash();
            return $redirect->to('admin/login');
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $messages->add('error', 'User is banned.')->flash();
            return $redirect->to('admin/login');
        }
    }
}
