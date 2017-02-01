<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Support\Hydrator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class FieldTypeBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldTypeBuilder
{

    use DispatchesJobs;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    private $hydrator;

    /**
     * The service container.
     *
     * @var Container
     */
    private $container;

    /**
     * The field type collection.
     *
     * @var FieldTypeCollection
     */
    private $fieldTypes;

    /**
     * Handle the command.
     *
     * @param Hydrator $hydrator
     * @param Container $container
     * @param FieldTypeCollection $fieldTypes
     */
    public function __construct(Hydrator $hydrator, Container $container, FieldTypeCollection $fieldTypes)
    {
        $this->hydrator   = $hydrator;
        $this->container  = $container;
        $this->fieldTypes = $fieldTypes;
    }

    /**
     * Build a field type.
     *
     * @param  array $parameters
     * @return FieldType
     */
    public function build(array $parameters)
    {
        $type = array_get($parameters, 'type');

        /*
         * If the field type is a string and
         * contains some kind of namespace for
         * streams then it's a class path and
         * we can resolve it from the container.
         */
        if (is_string($type) && str_contains($type, '\\') && class_exists($type)) {
            $type = clone($this->container->make($type));
        }

        /*
         * If the field type is a dot format
         * namespace then we can also resolve
         * the field type from the container.
         */
        if (is_string($type) && str_is('*.*.*', $type)) {
            $type = $this->fieldTypes->get($type);
        }

        /*
         * If we have gotten this far then it's
         * likely a simple slug and we can try
         * returning the first match for the slug.
         */
        if (is_string($type)) {
            $type = $this->fieldTypes->findBySlug($type);
        }

        /*
         * If we don't have a field type let em know.
         */
        if (!$type) {
            throw new \Exception("Field type [{$parameters['type']}] not found.");
        }

        $type->mergeRules(array_pull($parameters, 'rules', []));
        $type->mergeConfig(array_pull($parameters, 'config', []));

        $this->hydrator->hydrate($type, $parameters);

        return $type;
    }
}
