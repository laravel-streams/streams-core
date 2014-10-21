<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Routing\Controller;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

class BaseController extends Controller
{
    use CommandableTrait;
}
