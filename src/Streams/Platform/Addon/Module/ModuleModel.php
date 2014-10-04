<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Model\EloquentModel;

class ModuleModel extends EloquentModel
{
    /**
     * Define the table name.
     *
     * @var string
     */
    protected $table = 'addons_modules';

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
