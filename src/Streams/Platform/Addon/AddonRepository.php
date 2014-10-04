<?php namespace Streams\Platform\Addon;

class AddonRepository
{
    protected $loaded;

    function __construct(array $loaded)
    {
        $this->loaded = $loaded;
    }

    /**
     * Get an addon.
     *
     * @param null $slug
     * @return null|AddonCollection
     */
    public function get($slug = null)
    {
        foreach ($this->loaded as $abstract) {
            if (ends_with($abstract, '.' . $slug)) {
                return app('streams.decorator')->decorate(app($abstract));
            }
        }

        return null;
    }

    /**
     * Get all addons.
     *
     * @return AddonCollection
     */
    public function all()
    {
        return $this->newCollection(
            array_map(
                function ($abstract) {
                    return app('streams.decorator')->decorate(app($abstract));
                },
                $this->loaded
            )
        );
    }

    /**
     * Return a new collection instance.
     *
     * @param array $addons
     * @return AddonCollection
     */
    protected function newCollection(array $addons)
    {
        return new AddonCollection($addons);
    }
}
