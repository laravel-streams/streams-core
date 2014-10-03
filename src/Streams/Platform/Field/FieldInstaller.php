<?php namespace Streams\Platform\Field;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;

class FieldInstaller extends Installer
{
    /**
     * Fields to install.
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
     * The field service.
     *
     * @var \Streams\Platform\Field\FieldService
     */
    protected $fieldService;

    /**
     * Create a new FieldInstaller instance.
     *
     * @param AddonAbstract $addon
     */
    public function __construct(AddonAbstract $addon, FieldService $fieldService)
    {
        $this->addon        = $addon;
        $this->fieldService = $fieldService;
    }

    /**
     * Install the fields.
     *
     * @return bool
     */
    public function install()
    {
        foreach ($this->fields as $slug => $field) {

            // Catch some convenient defaults.
            $field['namespace'] = isset($field['namespace']) ? $field['namespace'] : $this->addon->getSlug();
            $field['lang']      = isset($field['namespace']) ? $field['namespace'] : $this->addon->getAbstract();
            $field['slug']      = $slug;

            $this->fieldService->add($field);
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
        foreach ($this->fields as $slug => $field) {
            $namespace = isset($field['namespace']) ? $field['namespace'] : $this->addon->getSlug();

            $this->fieldService->remove($namespace, $slug);
        }

        return true;
    }
}
 