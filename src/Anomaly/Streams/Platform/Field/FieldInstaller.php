<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Contract\InstallableInterface;

/**
 * Class FieldInstaller
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field
 */
class FieldInstaller implements InstallableInterface
{

    /**
     * The addon type using this installer.
     *
     * @var null
     */
    protected $addonType = null;

    /**
     * The namespace of the fields.
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
     * The field service object.
     *
     * @var FieldService
     */
    protected $fieldService;

    /**
     * Create a new FieldInstaller instance.
     *
     * @param FieldService $fieldService
     */
    public function __construct(FieldService $fieldService)
    {
        $this->fieldService = $fieldService;

        $this->setAddonType();
        $this->setNamespace();

        $this->boot();
    }

    /**
     * Set up the class.
     */
    protected function boot()
    {
        //
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

            // Catch some convenient defaults.
            $field['slug'] = $slug;

            $field['namespace'] = $this->getNamespace($field);
            $field['name']      = $this->getName($field);

            $this->fieldService->create($field);
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

            $namespace = $this->getNamespace($field);

            $this->fieldService->delete($namespace, $slug);
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

    /**
     * Get the namespace of a field.
     *
     * @param $field
     * @return null
     */
    protected function getNamespace($field)
    {
        return isset($field['namespace']) ? $field['namespace'] : $this->namespace;
    }

    /**
     * Get the name of a field.
     *
     * @param $field
     * @return string
     */
    protected function getName($field)
    {
        $default = "{$this->addonType}." . $field['namespace'] . "::field.{$field['slug']}.name";

        return isset($field['name']) ? $field['name'] : $default;
    }

    /**
     * Sett he addon type.
     */
    protected function setAddonType()
    {
        if (!$this->addonType) {

            $addonType = explode('\\', (new \ReflectionClass($this))->getName());

            $this->addonType = snake_case($addonType[3]);
        }
    }

    /**
     * Set the default namespace.
     */
    protected function setNamespace()
    {
        if (!$this->namespace) {

            $namespace = (new \ReflectionClass($this))->getShortName();
            $namespace = str_replace('FieldInstaller', null, $namespace);

            $this->namespace = snake_case($namespace);
        }
    }
}
