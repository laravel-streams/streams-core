<?php namespace Streams\Platform\Addon\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Installer\FieldInstaller;
use Streams\Platform\Stream\Installer\StreamInstaller;

class AddonInstaller extends Installer
{
    /**
     * The streams to install.
     *
     * @var array
     */
    protected $streams = [];

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
     * Create a new AddonInstallerAbstract instance.
     *
     * @param AddonAbstract $addon
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;

        $this->fieldInstaller = $this->newFieldInstaller();
    }

    /**
     * Install the addon.
     *
     * @return bool
     */
    public function install()
    {
        \Event::fire('installer.addon::before_install', [$this]);
        \Event::fire('installer.' . $this->addon->getType() . '::before_install', [$this]);

        $this->installFields();
        $this->installStreams();
        $this->save();

        \Event::fire('installer.addon::after_install', [$this]);
        \Event::fire('installer.' . $this->addon->getType() . '::after_install', [$this]);

        return true;
    }

    /**
     * Install the fields.
     *
     * @return bool
     */
    protected function installFields()
    {
        foreach ($this->fields as $slug => $field) {

            if (!isset($field['slug'])) {
                $field['slug'] = $slug;
            }

            $this->fieldInstaller->setField($field)->install();
        }

        return true;
    }

    /**
     * Install the streams.
     *
     * @return bool
     */
    protected function installStreams()
    {
        foreach ($this->streams as $stream) {
            $class = get_called_class();
            $class = explode('\\', $class);

            array_pop($class);

            $class[] = studly_case($stream . '_stream_installer');

            $class = implode('\\', $class);

            $method = studly_case('new_' . $stream . '_stream_installer');

            if (method_exists($this, $method)) {
                $class = call_user_func_array([$this, $method], [$this->addon]);
            } else {
                if (class_exists($class)) {
                    $class = new $class($this->addon);
                }
            }

            if ($class instanceof StreamInstaller) {
                $class->install();
            }
        }

        return true;
    }

    /**
     * Save the state of the installation.
     *
     * @return bool
     */
    protected function save()
    {
        $this->addon
            ->newModel()
            ->findBySlug($this->addon->getSlug())
            ->installed();

        return true;
    }

    /**
     * Uninstall an addon.
     *
     * @return bool
     */
    public function uninstall()
    {
        $addon = $this->addon->newModel()->findBySlug($this->addon->getSlug());

        \StreamSchemaUtility::destroyNamespace($addon->namespace);

        $addon->uninstalled();

        return true;
    }

    /**
     * Return a new FieldInstallerInstance.
     *
     * @return FieldInstaller
     */
    protected function newFieldInstaller()
    {
        return new FieldInstaller($this->addon);
    }
}
