<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Model\EloquentModel;

class ModuleModel extends EloquentModel
{
    /**
     * Define the table name.
     *
     * @var string
     */
    protected $table = 'addons_modules';

    /**
     * Disable timestamps for this model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Mark an addon as installed.
     *
     * @param $slug
     * @return mixed
     */
    public function installed($slug)
    {
        $module = $this->whereSlug($slug)->first();

        $module->is_enabled   = true;
        $module->is_installed = true;

        $module->save();

        return $module;
    }

    /**
     * Mark an addon as uninstalled.
     *
     * @param $slug
     * @return mixed
     */
    public function uninstalled($slug)
    {
        $module = $this->whereSlug($slug)->first();

        $module->is_enabled   = false;
        $module->is_installed = false;

        $module->save();

        return $module;
    }
}
