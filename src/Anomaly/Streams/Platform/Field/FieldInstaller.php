<?php namespace Anomaly\Streams\Platform\Field;

class FieldInstaller
{
    protected $namespace = null;

    protected $fields = [];

    protected $service;

    public function __construct(FieldService $service)
    {
        $this->service = $service;

        if (!$this->namespace) {

            $namespace = (new \ReflectionClass($this))->getShortName();
            $namespace = str_replace('FieldInstaller', null, $namespace);

            $this->namespace = snake_case($namespace);

        }
    }

    public function install()
    {
        foreach ($this->fields as $slug => $field) {

            // Catch some convenient defaults.
            $field['slug'] = $slug;

            $field['namespace'] = $this->getNamespace($field);
            $field['name']      = $this->getName($field);

            $this->service->add($field);

        }

        return true;
    }

    public function uninstall()
    {
        foreach ($this->fields as $slug => $field) {

            $namespace = $this->getNamespace($field);

            $this->service->remove($namespace, $slug);

        }

        return true;
    }

    protected function getNamespace($field)
    {
        return isset($field['namespace']) ? $field['namespace'] : $this->namespace;
    }

    protected function getName($field)
    {
        $default = 'module.' . $field['namespace'] . "::field.{$field['slug']}.name";

        return isset($field['name']) ? $field['name'] : $default;
    }
}
