<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class ExtensionModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionModel extends EloquentModel implements ExtensionInterface
{

    /**
     * Define the table name.
     *
     * @var string
     */
    protected $table = 'addons_extensions';

    /**
     * Disable timestamps for extensions.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Find a extension by it's slug or return a new
     * extension with the given slug.
     *
     * @param  $slug
     * @return ExtensionModel
     */
    public function findBySlugOrNew($slug)
    {
        $extension = $this->findBySlug($slug);

        if ($extension instanceof ExtensionModel) {
            return $extension;
        }

        $extension = $this->newInstance();

        $extension->slug = $slug;

        $extension->save();

        return $extension;
    }

    /**
     * Find a extension by it's slug.
     *
     * @param  $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }
}
