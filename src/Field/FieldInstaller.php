<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\Installable;

/**
 * Class FieldInstaller
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldInstaller implements Installable
{

    /**
     * The namespace if different than
     * the addon slug.
     *
     * @var null
     */
    protected $namespace = null;

    /**
     * The field configurations.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * The field manager.
     *
     * @var FieldManager
     */
    protected $manager;

    /**
     * The addon object.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * Create a new FieldInstaller instance.
     *
     * @param FieldManager $manager
     */
    public function __construct(FieldManager $manager, Addon $addon)
    {
        $this->addon   = $addon;
        $this->manager = $manager;
    }

    /**
     * Install the fields.
     *
     * @return bool
     */
    public function install()
    {
        foreach ($this->getFields() as $slug => $field) {

            if (is_string($field)) {
                $field = ['type' => $field];
            }

            $type   = array_get($field, 'type');
            $rules  = array_get($field, 'rules', []);
            $config = array_get($field, 'config', []);
            $locked = (array_get($field, 'locked', true));

            $namespace = array_get($field, 'namespace', $this->namespace ?: $this->addon->getSlug());
            $name      = array_get($field, 'name', $this->addon->getNamespace("field.{$slug}.name"));

            $this->manager->create(compact('slug', 'type', 'namespace', 'name', 'rules', 'config', 'locked'));
        }

        return true;
    }

    /**
     * Uninstall the fields.
     *
     * @return bool
     */
    public function uninstall()
    {
        foreach ($this->getFields() as $slug => $field) {

            $namespace = array_get($field, 'namespace', $this->addon->getSlug());

            $this->manager->delete($namespace, $slug);
        }

        return true;
    }

    /**
     * Get the fields.
     *
     * @return array
     */
    protected function getFields()
    {
        return $this->fields;
    }
}
