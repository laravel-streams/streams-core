<?php namespace Streams\Core\Http\Controller;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        $this->module = \Module::active();

        $this->messages = \App::make('messages');
    }
}
