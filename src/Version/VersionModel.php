<?php namespace Anomaly\Streams\Platform\Version;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VersionModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VersionModel extends Model
{

    /**
     * The model table.
     *
     * @var string
     */
    protected $table = 'versions';

    /**
     * The primary key.
     *
     * @var string
     */
    public $primaryKey = 'version_id';

    /**
     * Set the versionable attributes.
     *
     * @param EloquentModel $value
     */
    public function setVersionableAttribute(EloquentModel $value)
    {
        $this->attributes['versionable_id']   = $value->getId();
        $this->attributes['versionable_type'] = get_class($value);
    }
}
