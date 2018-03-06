<?php namespace Anomaly\Streams\Platform\Version\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

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
     * Fired during the query for entries.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $query->where('versionable_type', $this->getType());
        $query->where('versionable_id', $this->getId());
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

}
