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

            if (method_exists($type, 'getRelation')) {
                return $this->__getDecorator()->decorate($this->object->{$key});
            }

            return $type->setEntry($this->object)->getPresenter();
        }

        return parent::__get($key);
    }

    /**
     * Return the date string for created at.
     *
     * @return string
     */
    public function createdAtDate()
    {
        return $this->object->created_at
            ->setTimezone(config('app.timezone'))
            ->format(config('streams.date_format'));
    }

    /**
     * Return the datetime string for created at.
     *
     * @return string
     */
    public function createdAtDatetime()
    {
        return $this->object->created_at
            ->setTimezone(config('app.timezone'))
            ->format(config('streams.date_format') . ' ' . config('streams.time_format'));
    }

    /**
     * Return the date string for updated at.
     *
     * @return string
     */
    public function updatedAtDate()
    {
        return $this->object->updated_at
            ->setTimezone(config('app.timezone'))
            ->format(config('streams.date_format'));
    }

    /**
     * Return the datetime string for updated at.
     *
     * @return string
     */
    public function updatedAtDatetime()
    {
        return $this->object->updated_at
            ->setTimezone(config('app.timezone'))
            ->format(config('streams.date_format') . ' ' . config('streams.time_format'));
    }

    /**
     * Return the edit link.
     *
     * @return string
     */
    public function editLink()
    {
        return app('html')->link(
            implode(
                '/',
                array_unique(
                    array_filter(
                        [
                            'admin',
                            $this->object->getStreamNamespace(),
                            $this->object->getStreamSlug(),
                            'edit',
                            $this->object->getId()
                        ]
                    )
                )
            ),
            $this->object->getTitle()
        );
    }

    /**
     * Return the view link.
     *
     * @return string
     */
    public function viewLink()
    {
        return app('html')->link(
            implode(
                '/',
                array_unique(
                    array_filter(
                        [
                            'admin',
                            $this->object->getStreamNamespace(),
                            $this->object->getStreamSlug(),
                            'show',
                            $this->object->getId()
                        ]
                    )
                )
            ),
            $this->object->getTitle()
        );
    }
}
