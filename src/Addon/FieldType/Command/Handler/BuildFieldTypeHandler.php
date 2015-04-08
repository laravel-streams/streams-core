<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command\Handler;

use Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Illuminate\Container\Container;

/**
 * Class BuildFieldTypeHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType\Command
 */
class BuildFieldTypeHandler
{

    /**
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Loaded field types.
     *
     * @var FieldTypeCollection
     */
    protected $fieldTypes;

    /**
     * Create a new BuildFieldTypeHandler instance.
     */
    public function __construct(Container $container, FieldTypeCollection $fieldTypes)
    {
        $this->container  = $container;
        $this->fieldTypes = $fieldTypes;
    }

    /**
     * Handle the command.
     *
     * @param  BuildFieldType $command
     * @return mixed
     */
    public function handle(BuildFieldType $command)
    {
        $parameters = $command->getParameters();

        return $this->hydrate($this->getFieldType(array_pull($parameters, 'type')), $parameters);
    }

    /**
     * Get the field type class.
     *
     * @param  BuildFieldType $command
     * @return FieldType
     */
    protected function getFieldType($type)
    {
        /**
         * If the field type is an instance
         * of the field type class then
         * just return it as is.
         */
        if ($type instanceof FieldType) {
            return $type;
        }

        /**
         * If the field type is a string and
         * starts with the root namespace for
         * streams then it's a class path and
         * we can resolve it from the container.
         */
        if (is_string($type) && starts_with($type, 'Anomaly') && class_exists($type)) {
            return $this->container->make($type);
        }

        /**
         * If the field type is a dot format
         * namespace then we can also resolve
         * the field type from the container.
         */
        if (str_is('*.*.*', $type)) {
            return clone($this->container->make($type));
        }

        /**
         * If we have gotten this far then it's
         * likely a simple slug and we can try
         * returning the first match for the slug.
         */
        $type = $this->fieldTypes->findBySlug($type);

        /**
         * If we don't have a field type let em know.
         */
        if (!$type instanceof FieldType) {
            throw new \Exception("Field type [{$type}] not found.");
        }

        /**
         * Always clone back field types because
         * they are modified from use to use.
         */

        return clone($type);
    }

    /**
     * Hydrate the field type object with the parameters.
     *
     * @param FieldType $fieldType
     * @param array     $parameters
     * @return FieldType
     */
    protected function hydrate(FieldType $fieldType, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($fieldType, $method)) {
                $fieldType->{$method}($value);
            }
        }

        $fieldType->mergeRules(array_get($parameters, 'rules', []));
        $fieldType->mergeConfig(array_get($parameters, 'config', []));

        return $fieldType;
    }
}
