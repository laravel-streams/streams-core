<?php namespace Anomaly\Streams\Platform\Model;

use Robbo\Presenter\Presenter;

/**
 * Class EloquentPresenter
 * The base presenter for all our models.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Model
 */
class EloquentPresenter extends Presenter
{

    /**
     * Create a new EloquentPresenter instance.
     *
     * @param $object
     */
    public function __construct($object)
    {
        if ($object instanceof EloquentModel) {
            $this->object = $object;
        }
    }

    /**
     * Return the ID.
     *
     * @return mixed
     */
    public function id()
    {
        return $this->object->getKey();
    }
}
