<?php namespace Streams\Platform\Foundation;

interface ApplicationInterface
{
    /**
     * Check if the application is installed.
     *
     * @return mixed
     */
    public function isInstalled();

    /**
     * Setup the application.
     *
     * @return mixed
     */
    public function setup();

    /**
     * Get the application reference.
     *
     * @return mixed
     */
    public function getReference();
}
