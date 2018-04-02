<?php namespace Anomaly\Streams\Platform\Version\Table;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\Traits\Versionable;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Version\Contract\VersionInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
     * @var null|VersionInterface
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
        'order_by' => [
            'version' => 'DESC',
        ],
    ];

    /**
     * Fired just before building.
     */
    public function onReady()
    {
        $versionable = $this->getVersionableInstance();

        if ($current = $versionable->getCurrentVersion()) {
            $this->setCurrent($current);
        }
    }

    /**
     * Fired during the query for entries.
     *
     * @param Builder    $query
     * @param Repository $config
     */
    public function onQuerying(Builder $query, Repository $config)
    {
        $query->where('versionable_type', $this->getType());
        $query->where('versionable_id', $this->getId());

        $model = $config->get('auth.providers.users.model');

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
     * Get the current version.
     *
     * @return VersionInterface|null
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set the current version.
     *
     * @param VersionInterface $current
     * @return $this
     */
    public function setCurrent(VersionInterface $current)
    {
        $this->current = $current;

        return $this;
    }

}
