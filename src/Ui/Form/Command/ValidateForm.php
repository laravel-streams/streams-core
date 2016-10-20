<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Container\Container;

/**
 * Class ValidateForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ValidateForm
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new ValidateForm instance.
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
        $validator = $this->builder->getValidator();

        /*
         * If it's self handling just add @handle
         */
        if ($validator && !str_contains($validator, '@')) {
            $validator .= '@handle';
        }

        /*
         * If the validator is a string or Closure then it's a handler
         * and we and can resolve it through the service container.
         */
        if (is_string($validator) || $validator instanceof \Closure) {
            $container->call($validator, ['builder' => $this->builder]);
        }
    }
}
