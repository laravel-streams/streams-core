<?php namespace Anomaly\Streams\Platform\Field;

class FieldInstaller
{

    protected $addonType = null;

    protected $namespace = null;

    protected $fields = [];

    protected $fieldService;

    public function __construct(FieldService $fieldService)
    {
        $this->fieldService = $fieldService;

        $this->setAddonType();
        $this->setNamespace();
    }

    public function install()
    {
        foreach ($this->getFields() as $slug => $field) {

            // Catch some convenient defaults.
            $field['slug'] = $slug;

            $field['namespace'] = $this->getNamespace($field);
            $field['name']      = $this->getName($field);

            $this->fieldService->add($field);
        }

        return true;
    }

    public function uninstall()
    {
        foreach ($this->getFields() as $slug => $field) {

            $namespace = $this->getNamespace($field);

            $this->fieldService->remove($namespace, $slug);
        }

        return true;
    }

    protected function getFields()
    {
        return $this->fields;
    }

    protected function getNamespace($field)
    {
        return isset($field['namespace']) ? $field['namespace'] : $this->namespace;
    }

    protected function getName($field)
    {
        $default = "{$this->addonType}." . $field['namespace'] . "::field.{$field['slug']}.name";

        return isset($field['name']) ? $field['name'] : $default;
    }

    protected function setAddonType()
    {
        if (!$this->addonType) {

            $addonType = explode('\\', (new \ReflectionClass($this))->getName());

            $this->addonType = snake_case($addonType[3]);
        }
    }

    protected function setNamespace()
    {
        if (!$this->namespace) {

            $namespace = (new \ReflectionClass($this))->getShortName();
            $namespace = str_replace('FieldInstaller', null, $namespace);

            $this->namespace = snake_case($namespace);
        }
    }
}
