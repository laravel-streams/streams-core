<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Field;

use Illuminate\Support\ServiceProvider;

/**
 * Class FieldServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Field
 */
class FieldServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Register bindings.
     */
    protected function registerBindings()
    {
        $this->app->instance(
            'streams::table.field.factory',
            'Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldFactory'
        );
    }
}
