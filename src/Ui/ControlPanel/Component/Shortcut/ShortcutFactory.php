<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class ShortcutFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutFactory
{

    /**
     * The default shortcut class.
     *
     * @var string
     */
    protected $shortcut = Shortcut::class;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Make the shortcut from it's parameters.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        $shortcut = App::make(Arr::get($parameters, 'shortcut', $this->shortcut), $parameters);

        Hydrator::hydrate($shortcut, $parameters);

        return $shortcut;
    }
}
