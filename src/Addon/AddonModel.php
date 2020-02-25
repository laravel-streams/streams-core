<?php

namespace Anomaly\Streams\Platform\Addon;


use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class AddonModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonModel extends EloquentModel
{

    // protected $primaryKey = 'namespace';
    // protected $keyType = 'string';

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'streams_addons';

    /**
     * The casted attributes.
     *
     * @var array
     */
    protected $casts = [
        'enabled' => 'boolean',
        'installed' => 'boolean',
    ];
}
