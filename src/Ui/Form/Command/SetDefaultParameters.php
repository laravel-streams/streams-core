<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultParameters
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetDefaultParameters implements SelfHandling
{

    /**
     * Default properties.
     *
     * @var array
     */
    protected $defaults = [
        'handler'   => 'Anomaly\Streams\Platform\Ui\Form\FormHandler@handle',
        'validator' => 'Anomaly\Streams\Platform\Ui\Form\FormValidator@validate'
    ];

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormColumnsCommand instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetDefaultParameters $command
     */
    public function handle()
    {
        /**
         * Set the form mode according
         * to the builder's entry.
         */
        if (!$this->builder->getFormMode()) {
            $this->builder->setFormMode($this->builder->getEntry() ? 'edit' : 'create');
        }

        /**
         * Next we'll loop each property and look for a handler.
         */
        $reflection = new \ReflectionClass($this->builder);

        /* @var \ReflectionProperty $property */
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) {

            /**
             * If there is no getter then skip it.
             */
            if (!method_exists($this->builder, $method = 'get' . ucfirst($property->getName()))) {
                continue;
            }

            /**
             * If the parameter already
             * has a value then skip it.
             */
            if ($this->builder->{$method}()) {
                continue;
            }

            /**
             * Check if we can transform the
             * builder property into a handler.
             * If it exists, then go ahead and use it.
             */
            $handler = str_replace('FormBuilder', 'Form' . ucfirst($property->getName()), get_class($this->builder));

            if (class_exists($handler)) {

                /**
                 * Make sure the handler is
                 * formatted properly.
                 */
                if (!str_contains($handler, '@')) {
                    $handler .= '@handle';
                }

                $this->builder->{'set' . ucfirst($property->getName())}($handler);

                continue;
            }

            /**
             * If the handler does not exist and
             * we have a default handler, use it.
             */
            if ($default = array_get($this->defaults, $property->getName())) {
                $this->builder->{'set' . ucfirst($property->getName())}($default);
            }
        }
    }
}
