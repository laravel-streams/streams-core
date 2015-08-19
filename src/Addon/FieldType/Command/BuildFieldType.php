<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Support\Hydrator;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;

/**
 * Class BuildFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType\Command
 */
class BuildFieldType implements SelfHandling
{

    /**
     * The parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Create a new BuildFieldType instance.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Handle the command.
     *
     * @param Hydrator            $hydrator
     * @param Container           $container
     * @param FieldTypeCollection $fieldTypes
     * @return FieldType
     * @throws \Exception
     */
    public function handle(Hydrator $hydrator, Container $container, FieldTypeCollection $fieldTypes)
    {
        $type = array_pull($this->parameters, 'type');

        /**
         * If the field type is a string and
         * starts with the root namespace for
         * streams then it's a class path and
         * we can resolve it from the container.
         */
        if (is_string($type) && starts_with($type, 'Anomaly') && class_exists($type)) {
            $type = clone($container->make($type));
        }

        /**
         * If the field type is a dot format
         * namespace then we can also resolve
         * the field type from the container.
         */
        if (is_string($type) && str_is('*.*.*', $type)) {
            $type = clone($container->make($type));
        }

        /**
         * If we have gotten this far then it's
         * likely a simple slug and we can try
         * returning the first match for the slug.
         */
        if (is_string($type)) {
            $type = clone($fieldTypes->findBySlug($type));
        }

        /**
         * If we don't have a field type let em know.
         */
        if (!$type instanceof FieldType) {
            throw new \Exception("Field type [{$type}] not found.");
        }

        $type->mergeRules(array_pull($this->parameters, 'rules', []));
        $type->mergeConfig(array_pull($this->parameters, 'config', []));

        $hydrator->hydrate($type, $this->parameters);

        return $type;
    }
}
