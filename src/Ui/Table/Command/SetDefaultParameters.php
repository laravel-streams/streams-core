<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

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
    protected $defaults = [];

    /**
     * Set the table model object from the builder's model.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
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
            $handler = str_replace('TableBuilder', 'Table' . ucfirst($property->getName()), get_class($builder));

            if (class_exists($handler)) {

                /*
                 * Make sure the handler is
                 * formatted properly.
                 */
                if (!str_contains($handler, '@')) {
                    $handler .= '@handle';
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
