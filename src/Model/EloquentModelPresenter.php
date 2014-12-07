<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class EloquentModelPresenter
 * The base presenter for all our models.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentModelPresenter extends Presenter
{

    /**
     * Create a new EloquentModelPresenter instance.
     *
     * @param $resource
     */
    public function __construct($resource)
    {
        if ($resource instanceof EloquentModel) {

            $this->resource = $resource;
        }
    }

    /**
     * Return the ID.
     *
     * @return mixed
     */
    public function id()
    {
        return $this->resource->getKey();
    }
}
