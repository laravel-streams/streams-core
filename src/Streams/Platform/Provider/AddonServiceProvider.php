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
        $this->registerAddonTypes();
    }

    /**
     * Register addon types.
     */
    protected function registerAddonTypes()
    {
        foreach ($this->types as $type => $manager) {
            app()->instance(
                'streams.' . $type,
                (new $manager(app()->make('streams.loader'), app()->make('files')))->register(app())
            );
        }
    }
}
