<?php

namespace Anomaly\Streams\Platform\Version\Table;

use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Model\Traits\Versionable;
use Anomaly\Streams\Platform\Version\VersionModel;

/**
 * Class VersionTableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VersionTableBuilder extends TableBuilder
{

    /**
     * The versionable ID.
     *
     * @var null|int
     */
    protected $id = null;

    /**
     * The versionable type.
     *
     * @var null|string
     */
    protected $type = null;

    /**
     * The current version.
     *
     * @var mixed
     */
    protected $current = null;

    /**
     * The table filters.
     *
     * @var array
     */
    protected $filters = [
        'search' => [
            'columns' => [
                'username',
                'email',
            ],
        ],
        'created_at',
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'order_by'   => [
            'version' => 'DESC',
        ],
        'breadcrumb' => 'streams::breadcrumb.revisions',
    ];

    /**
     * Fired when the builder is ready to build.
     */
    public function onReady()
    {
        $this->guessPermission();
    }

    /**
     * Guess the permission required to read
     * the versionable entry's history.
     *
     * The versionable stream is used rather than the table's,
     * which belongs to the versions themselves. A permission
     * the addon has not declared is granted rather than
     * denied, so only a declared one is worth setting.
     */
    protected function guessPermission()
    {
        if ($this->getOption('permission') !== null) {
            return;
        }

        if (!$type = $this->getType()) {
            return;
        }

        $model = new $type;

        if (!$model instanceof EntryModel || !$stream = $model->getStream()) {
            return;
        }

        if (!$route = app('request')->route()) {
            return;
        }

        if (!$namespace = array_get($route->getAction(), 'streams::addon')) {
            return;
        }

        foreach ([$stream->getSlug(), $stream->getNamespace()] as $group) {
            if (in_array('write', (array)config($namespace . '::permissions.' . $group))) {
                $this->setOption('permission', $namespace . '::' . $group . '.write');

                return;
            }
        }
    }

    /**
     * Fired during the query for entries.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $query->where('versionable_type', $this->getType());
        $query->where('versionable_id', $this->getId());

        $model = config('auth.providers.users.model');

        /* @var Model $model */
        $model = (new $model);

        $query->join(
            $model->getTable(),
            $this->getTableModel()->getTable() . '.created_by_id',
            '=',
            $model->getTable() . '.id'
        );
    }

    /**
     * Get the versionable instance.
     *
     * @return Versionable|EloquentModel
     */
    public function getVersionableInstance()
    {
        $type = $this->getType();
        $id   = $this->getId();

        return (new $type)->find($id);
    }

    /**
     * Get the ID.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the ID.
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the type.
     *
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type.
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the current version.
     *
     * @param VersionModel $current
     */
    public function setCurrent(VersionModel $current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get the current version.
     */
    public function getCurrent()
    {
        return $this->current;
    }
}
