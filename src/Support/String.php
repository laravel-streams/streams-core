<?php

namespace Anomaly\Streams\Platform\Support;

use TwigBridge\Bridge;

/**
 * Class String.
 *
 * @method render
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class String
{
    /**
     * The twig instance.
     *
     * @var Bridge
     */
    protected $twig;

    /**
     * Create a new String instance.
     */
    public function __construct()
    {
        $twig = clone(app('TwigBridge\Bridge'));

        $twig->setLoader(new \Twig_Loader_String());

        $this->twig = $twig;
    }

    /**
     * Call everything on twig.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->twig, $name], $arguments);
    }
}
