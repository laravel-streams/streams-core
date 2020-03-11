<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AddonModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonModel extends Model
{
    
    /**
     * No timestamps here.
     *
     * @var bool
     */
    public $timestamps = false;
    
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

    /**
     * The fillable attributes.
     *
     * @var array
     */
    protected $guarded = [];
}
