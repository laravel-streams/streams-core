<?php namespace Streams\Platform\Field;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonInterface;
use Streams\Platform\Field\Service\FieldManagerService;

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
     * @var \Streams\Platform\Addon\AddonInterface
     */
    protected $addon;

    /**
     * The field manager service.
     *
     * @var \Streams\Platform\Field\Service\FieldManagerService
     */
    protected $service;

    /**
     * Create a new FieldInstaller instance.
     *
     * @param AddonInterface $addon
     */
    public function __construct(AddonInterface $addon, FieldManagerService $service)
    {
        $this->addon   = $addon;
        $this->service = $service;
    }

    /**
     * Install the fields.
     *
     * @return bool
     */
    public function install()
    {
        foreach ($this->fields as $slug => $field) {
            $this->service->add($this->addon, array_merge($field, ['slug' => $slug]));
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
            $this->service->remove($this->addon, array_merge($field, ['slug' => $slug]));
        }

        return true;
    }
}
 