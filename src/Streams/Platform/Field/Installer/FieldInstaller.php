<?php namespace Streams\Platform\Field\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Model\FieldModel;

class FieldInstaller extends Installer
{
    /**
     * The field data.
     *
     * @var array
     */
    protected $field = [];

    /**
     * The addon object.
     *
     * @var \Streams\Platform\Addon\AddonAbstract
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
     * @return bool|void
     */
    public function install()
    {
        $this->installField();

        return true;
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