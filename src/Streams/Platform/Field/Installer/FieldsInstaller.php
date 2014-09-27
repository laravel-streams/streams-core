<?php namespace Streams\Platform\Field\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Model\FieldModel;

class FieldsInstaller extends Installer
{
    /**
     * The fields to install.
     *
     * @var array
     */
    protected $fields = [];

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
     * Install fields.
     *
     * @return bool|void
     */
    public function install()
    {
        $this->fire('before_install');

        foreach ($this->fields as $slug => $field) {
            $this->installField($slug, $field);
        }

        $this->fire('after_install');
    }

    /**
     * Install a field.
     *
     * @param $slug
     * @param $field
     */
    protected function installField($slug, $field)
    {
        $field = (new FieldModel())->fill($field);

        $field->slug = $slug;

        if (!$field->namespace) {
            $field->namespace = $this->addon->getSlug();
        }

        if (!$field->name) {
            $field->name = $this->addon->getType() . '.' . $field->namespace . '::field.' . $field->slug . '.name';
        }

        $field->is_locked = boolean($field->is_locked);

        $field->save();
    }
}
