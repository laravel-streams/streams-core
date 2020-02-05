<?php

namespace Anomaly\Streams\Platform\Model\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class Streams
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Streams
{

    /**
     * The translating locale.
     *
     * @var null|string
     */
    protected $stream = [];

    
}
