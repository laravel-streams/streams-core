<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Routing\Controller;
use Laracasts\Commander\CommanderTrait;

/**
 * Class BaseController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Controller
 */
class BaseController extends Controller
{

    use CommanderTrait;
}
