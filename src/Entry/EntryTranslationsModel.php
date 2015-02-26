<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class EntryTranslationsModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryTranslationsModel extends EloquentModel
{

    /**
     * The stream model.
     *
     * @var null
     */
    protected $stream = null;

    /**
     * Cache minutes.
     *
     * @var int
     */
    protected $cacheMinutes = 99999;

    /**
     * Create a new EntryTranslationsModel instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $model = str_replace('TranslationsModel', 'Model', get_class($this));

        $this->stream = (new $model)->getStream();

        parent::__construct($attributes);
    }
}
