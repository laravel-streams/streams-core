<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentPresenter;

/**
 * Class EntryPresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryPresenter extends EloquentPresenter
{
    /**
     * The decorated resource.
     *
     * @var EntryInterface
     */
    protected $resource;

    /**
     * Wrap with a decorated field type if possible.
     *
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($type = $this->resource->getFieldType($key)) {
            return $type->newPresenter();
        }

        return parent::getAttribute($key);
    }
}
