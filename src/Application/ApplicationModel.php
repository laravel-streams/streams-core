<?php namespace Anomaly\Streams\Platform\Application;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ApplicationModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Application
 */
class ApplicationModel extends Model
{

    /**
     * No timestamps right now.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model table.
     *
     * @var string
     */
    protected $table = 'applications';

}
