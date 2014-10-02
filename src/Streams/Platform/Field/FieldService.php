<?php namespace Streams\Platform\Field;

use Laracasts\Commander\CommanderTrait;
use Streams\Platform\Addon\AddonInterface;
use Streams\Platform\Field\Command\AddFieldCommand;
use Streams\Platform\Field\Command\RemoveFieldCommand;

class FieldService
{
    use CommanderTrait;

    /**
     * Add a field.
     *
     * @param array $field
     * @return mixed
     */
    public function add(array $field)
    {
        // Mandatory properties.
        $slug      = $field['slug'];
        $type      = $field['type'];
        $namespace = $field['namespace'];

        // Optional properties
        $rules    = isset($field['rules']) ? $field['rules'] : [];
        $settings = isset($field['settings']) ? $field['settings'] : [];
        $isLocked = isset($field['is_locked']) ? $field['is_locked'] : false;

        // Determine the field name.
        if (!isset($field['name'])) {
            if (isset($field['lang'])) {
                $field['name'] = "{$field['lang']}::field.{$field['slug']}.name";
            }
        }

        $name = isset($field['name']) ? $field['name'] : null;

        $command = new AddFieldCommand($namespace, $slug, $type, $name, $settings, $rules, $isLocked);

        return $this->execute($command);
    }

    /**
     * Remove a field.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function remove($namespace, $slug)
    {
        $command = new RemoveFieldCommand($namespace, $slug);

        return $this->execute($command);
    }
}
