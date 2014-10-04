<?php namespace Streams\Platform\Http\Controller;

use Illuminate\Routing\Controller;
use Streams\Platform\Traits\CommandableTrait;

class BaseController extends Controller
{
    use CommandableTrait;
}
