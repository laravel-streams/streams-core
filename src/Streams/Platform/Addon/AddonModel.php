<?php namespace Streams\Platform\Addon;

use Streams\Platform\Model\EloquentModel;

class AddonModel extends EloquentModel
{
    /**
     * Find an addon by it's slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->whereSlug($slug)->first();
    }

    /**
     * Mark an addon as installed.
     *
     * @param $slug
     * @return mixed
     */
    public function installed($slug)
    {
        $addon = $this->whereSlug($slug)->first();

        $addon->is_enabled   = true;
        $addon->is_installed = true;

        $addon->save();

        return $addon;
    }

    /**
     * Mark an addon as uninstalled.
     *
     * @param $slug
     * @return mixed
     */
    public function uninstalled($slug)
    {
        $addon = $this->whereSlug($slug)->first();

        $addon->is_enabled   = false;
        $addon->is_installed = false;

        $addon->save();

        return $addon;
    }
}
