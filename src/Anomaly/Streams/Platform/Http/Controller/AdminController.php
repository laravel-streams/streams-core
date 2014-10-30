<?php namespace Anomaly\Streams\Platform\Http\Controller;

class AdminController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }
}
