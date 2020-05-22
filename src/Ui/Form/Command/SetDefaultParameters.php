<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormHandler;
use Anomaly\Streams\Platform\Ui\Form\FormRules;
use Anomaly\Streams\Platform\Ui\Form\FormValidator;

/**
 * Class SetDefaultParameters
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetDefaultParameters
{

    /**
     * Skip these.
     *
     * @var array
     */
    protected $skips = [
        'model',
        'repository',
    ];

    /**
     * Default properties.
     *
     * @var array
     */
    protected $defaults = [
        'handler'   => FormHandler::class,
        'validator' => FormValidator::class,
    ];

    /**
     * Set the form model object from the builder's model.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        /*
         * Set the form mode according
         * to the builder's entry.
         */
        if (!$builder->mode) {
            $builder->mode = ($builder->getFormEntryId() || $builder->getEntry()) ? 'update' : 'create';
        }

        /*
         * Next we'll loop each property and look for a handler.
         */
        $reflection = new \ReflectionClass($builder);

        /* @var \ReflectionProperty $property */
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) {

            if (in_array($property->getName(), $this->skips)) {
                continue;
            }

            /*
             * If there is no getter then skip it.
             */
            if (!method_exists($builder, $method = 'get' . ucfirst($property->getName()))) {
                continue;
            }

            /*
             * If the parameter already
             * has a value then skip it.
             */
            if ($builder->{$method}()) {
                continue;
            }

            /*
             * Check if we can transform the
             * builder property into a handler.
             * If it exists, then go ahead and use it.
             */
            $handler = str_replace('FormBuilder', 'Form' . ucfirst($property->getName()), get_class($builder));

            if ($handler !== $builder && class_exists($handler)) {

                /*
                 * Make sure the handler is
                 * formatted properly.
                 */
                if (!str_contains($handler, '@')) {
                    $handler .= '@handle';
                }

                /**
                 * We have to make a special case
                 * for form rules since we have
                 * a service named the same.
                 */
                if ($property->getName() == 'rules' && $handler == FormRules::class . '@handle') {
                    continue;
                }

                $builder->{'set' . ucfirst($property->getName())}($handler);

                continue;
            }

            /*
             * If the handler does not exist and
             * we have a default handler, use it.
             */
            if ($default = array_get($this->defaults, $property->getName())) {
                $builder->{'set' . ucfirst($property->getName())}($default);
            }
        }
    }
}
