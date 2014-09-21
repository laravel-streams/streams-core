<?php namespace Streams\Platform\Http\Controller;

class AdminController extends BaseController
{
    /**
     * Display the admin login page.
     */
    public function login()
    {
        return \View::make('theme::login');
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

            \Messages::add('info', 'Welcome, ' . $user->name . '.')->flash();

            return \Redirect::intended('admin/dashboard');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            \Messages::add('error', 'Login field is required.')->flash();
            return \Redirect::to('admin/login');
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            \Messages::add('error', 'Password field is required.')->flash();
            return \Redirect::to('admin/login');
        } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
            \Messages::add('error', 'Wrong password, try again.')->flash();
            return \Redirect::to('admin/login');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            \Messages::add('error', 'User was not found.')->flash();
            return \Redirect::to('admin/login');
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            \Messages::add('error', 'User is not activated.')->flash();
            return \Redirect::to('admin/login');
        } catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            \Messages::add('error', 'User is suspended.')->flash();
            return \Redirect::to('admin/login');
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            \Messages::add('error', 'User is banned.')->flash();
            return \Redirect::to('admin/login');
        }
    }
}
