<?php namespace Streams\Platform\Addon;

interface AddonInterface
{
    /**
     * Get the type of the addon.
     *
     * @return mixed
     */
    public function getType();

    /**
     * Get the slug of the addon.
     *
     * @return mixed
     */
    public function getSlug();
}
