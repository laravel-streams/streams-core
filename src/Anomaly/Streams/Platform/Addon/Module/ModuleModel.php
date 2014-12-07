<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class ModuleModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleModel extends EloquentModel
{

    /**
     * Define the table name.
     *
     * @var string
     */
    protected $table = 'addons_modules';

    /**
     * Disable timestamps for modules.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Find a module by it's slug or return a new
     * module with the given slug.
     *
     * @param $slug
     * @return ModuleModel
     */
    public function findBySlugOrCreate($slug)
    {
        $module = $this->findBySlug($slug);

        if ($module instanceof ModuleModel) {

            return $module;
        }

        $module = $this->newInstance();

        $module->slug = $slug;

        $module->save();

        return $module;
    }

    /**
     * Find a module by it's slug.
     *
     * @param $slug
     * @return mixed
     */
    protected function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }
}
