<?php namespace Streams\Platform\Field;

class FieldInstaller
{
    /**
     * The default field namespace.
     *
     * @var null
     */
    protected $namespace = null;

    /**
     * Fields to install.
     *
     * @var array
     */
    protected $fields = [];

    protected $fieldService;

    public function __construct(FieldService $fieldService)
    {
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
            $field['namespace'] = isset($field['namespace']) ? $field['namespace'] : $this->namespace;
            $field['lang']      = isset($field['lang']) ? $field['lang'] : 'module.' . $field['namespace'];
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
            $namespace = isset($field['namespace']) ? $field['namespace'] : $this->namespace;

            $this->fieldService->remove($namespace, $slug);
        }

        return true;
    }
}
