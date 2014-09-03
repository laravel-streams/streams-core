<?php namespace Streams\Core\Controller;

class BaseController extends \Controller
{
    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        $this->module = \Module::getActive();

        $this->messages = \App::make('messages');
    }
}
