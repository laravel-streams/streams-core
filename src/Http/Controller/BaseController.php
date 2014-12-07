<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Illuminate\Routing\Controller;

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

    use CommandableTrait;
}
