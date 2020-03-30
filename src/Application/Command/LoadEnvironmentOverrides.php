<?php namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Application\Application;
use Dotenv\Dotenv;
use Dotenv\Environment\Adapter\EnvConstAdapter;
use Dotenv\Environment\Adapter\PutenvAdapter;
use Dotenv\Environment\Adapter\ServerConstAdapter;
use Dotenv\Environment\DotenvFactory;

/**
 * Class LoadEnvironmentOverrides
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadEnvironmentOverrides
{

    /**
     * Handle the command.
     *
     * @param Application $application
     */
    public function handle(Application $application)
    {
        if (!is_file($file = $application->getResourcesPath('.env'))) {
            return;
        }
//
//        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
//
//            // Check for # comments.
//            if (!starts_with($line, '#')) {
//                putenv($line);
//            }
//        }

        $dotenv = $this->createDotenv($application);
        $dotenv->overload();
    }

    /**
     * Create a Dotenv instance.
     *
     * @param  Application  $app
     * @return \Dotenv\Dotenv
     */
    protected function createDotenv(Application $application)
    {
        return Dotenv::create(
            $application->getResourcesPath(),
            '.env',
            new DotenvFactory([new EnvConstAdapter, new ServerConstAdapter, new PutenvAdapter])
        );
    }
}
