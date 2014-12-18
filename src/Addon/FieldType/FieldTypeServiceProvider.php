<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Illuminate\Support\ServiceProvider;

/**
 * Class FieldTypeServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCollection();

        $this->registerFieldTypes();
    }

    /**
     * Register the field type collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.field_types', new FieldTypeCollection());
    }

    /**
     * Register all the field type addons.
     */
    protected function registerFieldTypes()
    {
        $this->app->make('streams.addon.manager')->register('field_type');
    }
}
