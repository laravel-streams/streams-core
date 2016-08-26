<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Container\Container;

/**
 * Class HandleForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class HandleForm
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
     *
     * @param Container $container
     */
    public function handle(Container $container)
    {
        if ($this->builder->hasFormErrors()) {
            return;
        }

        $handler = $this->builder->getHandler();

        if ($handler && !str_contains($handler, '@')) {
            $handler .= '@handle';
        }

        $container->call($handler, ['builder' => $this->builder]);
    }
}
