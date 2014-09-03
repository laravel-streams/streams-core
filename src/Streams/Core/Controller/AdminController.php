<?php namespace Streams\Core\Controller;

class AdminController extends BaseController
{
    /**
     * Display the admin login page.
     */
    public function login()
    {
        return \View::make('login');
    }

    /**
     * Attempt to login.
     *
     * @return mixed
     */
    public function attemptLogin()
    {
        try {
            $credentials = [
                'email'    => \Request::get('email'),
                'password' => \Request::get('password'),
            ];

            // Let an event try and handle authenticating a login.
            if ($return = \Event::fire('user.authenticate', $credentials)) {
                return \Redirect::intended($return);
            }

            $user = \Sentry::authenticate($credentials, \Request::get('remember'));

            \Event::fire('user.login', $user);

            return \Redirect::intended('admin/dashboard');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return \Redirect::to('admin/login')->with('message', 'Login field is required.');
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return \Redirect::to('admin/login')->with('message', 'Password field is required.');
        } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
            return \Redirect::to('admin/login')->with('message', 'Wrong password, try again.');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return \Redirect::to('admin/login')->with('message', 'User was not found.');
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return \Redirect::to('admin/login')->with('message', 'User is not activated.');
        } catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            return \Redirect::to('admin/login')->with('message', 'User is suspended.');
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            return \Redirect::to('admin/login')->with('message', 'User is banned.');
        }
    }
}
