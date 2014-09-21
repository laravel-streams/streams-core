<?php namespace Streams\Platform\Addon\Model;

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
     * Mark the addon as installed and save.
     *
     * @return mixed
     */
    public function installed()
    {
        $this->is_enabled   = true;
        $this->is_installed = true;

        return $this->save();
    }

    /**
     * Mark the addon as uninstalled and save.
     *
     * @return mixed
     */
    public function uninstalled()
    {
        $this->is_enabled   = false;
        $this->is_installed = false;

        return $this->save();
    }
}
