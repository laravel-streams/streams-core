<?php namespace Streams\Core\Field\Installer;

use Streams\Core\Support\Installer;
use Streams\Core\Addon\AddonAbstract;
use Streams\Core\Field\Model\FieldModel;

class FieldInstaller extends Installer
{
    /**
     * The installation steps.
     *
     * @var array
     */
    protected $steps = [
        'install_field',
    ];

    /**
     * The field data.
     *
     * @var array
     */
    protected $field = [];

    /**
     * The addon object.
     *
     * @var \Streams\Core\Addon\AddonAbstract
     */
    protected $addon;

    /**
     * Create a new FieldInstaller instance.
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;

        $this->fields = new FieldModel();
    }

    /**
     * Install the field.
     *
     * @return bool
     */
    protected function installField()
    {
        $field = (new FieldModel())->fill($this->field);

        if (!$field->namespace) {
            $field->namespace = $this->addon->getSlug();
        }

        if (!$field->name) {
            $field->name = $this->addon->getType() . '.' . $field->namespace . '::field.' . $field->slug . '.name';
        }

        $field->is_locked = \StringHelper::bool($field->is_locked);

        return $field->save();
    }

    /**
     * Set the field data.
     *
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }
}