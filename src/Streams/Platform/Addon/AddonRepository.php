<?php namespace Streams\Platform\Addon;

class AddonRepository
{
    protected $type = null;

    /**
     * Get an addon.
     *
     * @param null $slug
     * @return null|AddonCollection
     */
    public function get($slug = null)
    {
        foreach (app("streams.{$this->type}.loaded") as $abstract) {
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
        $collection = $this->getCollection();

        return new $collection(
            array_map(
                function ($abstract) {
                    return app('streams.decorator')->decorate(app($abstract));
                },
                app("streams.{$this->type}.loaded")
            )
        );
    }

    protected function getCollection()
    {
        return (new AddonTypeClassResolver())->resolveCollection($this->type);
    }
}
