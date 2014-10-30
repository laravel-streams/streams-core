<?php namespace Anomaly\Streams\Platform\Field\Command;

class AddFieldCommand
{

    /**
     * The fields namespace.
     *
     * @var
     */
    protected $namespace;

    /**
     * The field slug.
     *
     * @var
     */
    protected $slug;

    /**
     * The field type.
     *
     * @var
     */
    protected $type;

    /**
     * The field name.
     *
     * @var
     */
    protected $name;

    /**
     * The field settings.
     *
     * @var
     */
    protected $settings;

    /**
     * The field validation rules.
     *
     * @var array
     */
    protected $rules;

    /**
     * Whether the field is locked or not.
     *
     * @var
     */
    protected $isLocked;

    /**
     * Create a new InstallFieldCommand instance.
     *
     * @param       $namespace
     * @param       $slug
     * @param       $type
     * @param array $settings
     * @param array $rules
     * @param       $isLocked
     */
    function __construct($namespace, $slug, $type, $name, array $settings, array $rules, $isLocked)
    {
        $this->slug      = $slug;
        $this->type      = $type;
        $this->name      = $name;
        $this->rules     = $rules;
        $this->settings  = $settings;
        $this->isLocked  = $isLocked;
        $this->namespace = $namespace;
    }

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the field namespace.
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the field type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the field name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the field settings.
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Get the field validation rules.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Get the field locked flag.
     *
     * @return mixed
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }
}
 