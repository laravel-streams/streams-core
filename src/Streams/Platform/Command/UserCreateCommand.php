<?php namespace Streams\Platform\Command;

use Illuminate\Console\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;

class  UserCreateCommand extends BaseCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $domain   = $this->ask('Which domain would you like to use? ');
        $email    = $this->ask('Which email would you like to use? ');
        $password = $this->ask('Which password? ');

        if (!\Application::locate($domain)) {
            $this->error('Application could not be located.');
        }

        try {
            // Create the user
            \Sentry::createUser(
                [
                    'email'     => $email,
                    'password'  => $password,
                    'is_activated' => true,
                ]
            );

            $this->info('User created!');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $this->error('Login field is required.');
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $this->error('Password field is required.');
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            $this->error('User with this login already exists.');
        } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            $this->error('Group was not found.');
        }
    }

}
