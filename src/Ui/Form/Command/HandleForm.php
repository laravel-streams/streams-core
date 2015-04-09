<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class HandleForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleForm implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new HandleForm instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        // If we can't save, skip it.
        if (!$this->builder->canSave()) {
            return;
        }

        $handler = $this->builder->getFormOption('handler');

        /**
         * If the handler is a callable string or Closure then
         * we and can resolve it through the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            app()->call($handler, ['builder' => $this->builder]);
        }
    }
}
