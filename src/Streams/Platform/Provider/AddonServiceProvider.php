<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Available addon types.
     *
     * @var array
     */
    protected $types = [
        'distributions' => 'Streams\Platform\Addon\Manager\DistributionManager',
        'field_types'   => 'Streams\Platform\Addon\Manager\FieldTypeManager',
        'extensions'    => 'Streams\Platform\Addon\Manager\ExtensionManager',
        'modules'       => 'Streams\Platform\Addon\Manager\ModuleManager',
        'blocks'        => 'Streams\Platform\Addon\Manager\BlockManager',
        'themes'        => 'Streams\Platform\Addon\Manager\ThemeManager',
        'tags'          => 'Streams\Platform\Addon\Manager\TagManager',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $loader = $this->app->make('streams.loader');
        $files  = $this->app->make('files');

        foreach ($this->types as $type => $manager) {
            $this->app->instance('streams.' . $type, (new $manager($loader, $files))->register($this->app));
        }
    }
}
