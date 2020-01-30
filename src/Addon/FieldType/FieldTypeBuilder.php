<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Support\Hydrator;
use Illuminate\Contracts\Container\Container;

/**
 * Class FieldTypeBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldTypeBuilder
{

    /**
     * Build a field type.
     *
     * @param  array $parameters
     * @return FieldType
     */
    public static function build(array $parameters)
    {
        $type = array_pull($parameters, 'type');

        /*
         * Make sure the type
         * parameter has been set.
         */
        if (!is_string($type)) {
            throw new \Exception(
                "The [type] parameter of [" . array_get($parameters, 'field') . "] is required and should be string."
            );
        }

        /*
         * If the field type is a string and
         * contains some kind of namespace for
         * streams then it's a class path and
         * we can resolve it from the container.
         */
        if (str_contains($type, '\\') && class_exists($type)) {
            $fieldType = clone (app($type));
        }

        /*
         * If the field type is a dot format
         * namespace then we can also resolve
         * the field type from the container.
         */
        if (!isset($fieldType) && str_is('*.*.*', $type)) {
            $fieldType = app($type);
        }

        /*
         * If we have gotten this far then it's
         * likely a simple slug and we can try
         * returning the first match for the slug.
         */
        if (!isset($fieldType)) {
            $fieldType = app('field_type.collection')->findBySlug($type);
        }

        /*
         * If we don't have a field type let em know.
         */
        if (!$fieldType) {
            throw new \Exception("Field type [$type] not found.");
        }

        $fieldType->mergeRules((array) array_pull($parameters, 'rules', []));
        $fieldType->mergeConfig((array) array_pull($parameters, 'config', []));

        Hydrator::hydrate($fieldType, $parameters);

        if ($entry = array_pull($parameters, 'entry')) {

            //
        }

        return $fieldType;
    }
}
