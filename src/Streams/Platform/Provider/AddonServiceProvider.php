<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Available addon types.
     *
     * @var array
     */
    protected $types = [
        'distributions' => 'Streams\Platform\Addon\DistributionManager',
        'field_types'   => 'Streams\Platform\Addon\FieldTypeManager',
        'extensions'    => 'Streams\Platform\Addon\ExtensionManager',
        'modules'       => 'Streams\Platform\Addon\ModuleManager',
        'blocks'        => 'Streams\Platform\Addon\BlockManager',
        'themes'        => 'Streams\Platform\Addon\ThemeManager',
        'tags'          => 'Streams\Platform\Addon\TagManager',
    ];

    /**
     * Iterate through all the addons and register them.
     * Then register each addon's own service provider.
     */
    public function register()
    {
        $files  = app('files');
        $loader = app('streams.loader');

        foreach ($this->types as $type => $manager) {
            $this->app->instance('streams.' . $type, (new $manager(app(), $loader, $files))->register());
        }

        foreach ($this->types as $type => $manager) {
            foreach (app('streams.' . $type)->all() as $addon) {
                $addon->register();
            }
        }
    }
}
