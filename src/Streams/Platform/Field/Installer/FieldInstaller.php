<?php namespace Streams\Platform\Field\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Model\FieldModel;

class FieldInstaller extends Installer
{
    /**
     * The field to install.
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
     * Create a new FieldsInstaller instance.
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;

        $this->model = new FieldModel();
    }

    /**
     * Install a field.
     *
     * @return bool|void
     */
    public function install()
    {
        $this->fire('before_install');

        $this->installField();

        $this->fire('after_install');
    }

    /**
     * Install a field.
     *
     * @return bool|void
     */
    public function uninstall()
    {
        $this->fire('before_uninstall');

        $this->uninstallField();

        $this->fire('after_uninstall');
    }

    /**
     * Install a field.
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

        $field->is_locked = boolean($field->is_locked);

        $field->save();
    }

    /**
     * Uninstall a field.
     */
    protected function uninstallField()
    {
        if ($field = (new FieldModel())->findBySlugAndNamespace($this->field['slug'], $this->addon->getSlug())) {
            $field->delete();
        }
    }

    /**
     * Set the field.
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
