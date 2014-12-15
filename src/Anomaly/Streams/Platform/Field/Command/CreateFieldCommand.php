<?php namespace Anomaly\Streams\Platform\Field\Command;

/**
 * Class CreateFieldCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class CreateFieldCommand
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
     * The field config.
     *
     * @var
     */
    protected $config;

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
    protected $locked;

    /**
     * Create a new CreateFieldCommand instance.
     *
     * @param       $namespace
     * @param       $slug
     * @param       $type
     * @param null  $name
     * @param array $config
     * @param array $rules
     * @param bool  $locked
     */
    public function __construct(
        $namespace,
        $slug,
        $type,
        $name = null,
        array $rules = [],
        array $config = [],
        $locked = false
    ) {
        $this->slug      = $slug;
        $this->type      = $type;
        $this->name      = $name;
        $this->rules     = $rules;
        $this->config    = $config;
        $this->locked    = $locked;
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
     * Get the field config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
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
    public function isLocked()
    {
        return $this->locked;
    }
}
