<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentModel;

class EntryTranslationsModel extends EloquentModel
{

    /**
     * The stream model.
     *
     * @var null
     */
    protected $stream = null;

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
