<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentPresenter;

/**
 * Class EntryPresenter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryPresenter extends EloquentPresenter
{

    /**
     * The resource object.
     * This is for IDE hinting.
     *
     * @var EntryInterface
     */
    protected $object;

    /**
     * When accessing a property of a decorated entry
     * object first check to see if the key represents
     * a streams field. If it does then return the field
     * type's presenter object. Otherwise handle normally.
     *
     * @param  $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($type = $this->object->getFieldType($key)) {
            return $type->getPresenter();
        }

        return parent::__get($key);
    }

    /**
     * Get the entry's edit link.
     *
     * @return string
     */
    public function presentEditLink()
    {
        return app('html')->link(
            implode(
                '/',
                array_filter(
                    [
                        'admin',
                        $this->object->getStreamNamespace(),
                        $this->object->getStreamSlug(),
                        'edit',
                        $this->object->getId()
                    ]
                )
            ),
            $this->object->getTitle()
        );
    }

    /**
     * Get the entry's view link.
     *
     * @return string
     */
    public function presentViewLink()
    {
        return app('html')->link(
            implode(
                '/',
                array_filter(
                    [
                        'admin',
                        $this->object->getStreamNamespace(),
                        $this->object->getStreamSlug(),
                        'show',
                        $this->object->getId()
                    ]
                )
            ),
            $this->object->getTitle()
        );
    }
}
