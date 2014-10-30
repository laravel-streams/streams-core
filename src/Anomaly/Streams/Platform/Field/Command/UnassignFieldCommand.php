<?php namespace Anomaly\Streams\Platform\Field\Command;

class UnassignFieldCommand
{

    /**
     * The field namespace to unassign.
     *
     * @var
     */
    protected $namespace;

    /**
     * The field stream to unassign.
     *
     * @var
     */
    protected $stream;

    /**
     * The field slug to unassign.
     *
     * @var
     */
    protected $field;

    /**
     * Create a new UnassignFieldCommand instance.
     *
     * @param $namespace
     * @param $stream
     * @param $field
     */
    function __construct($namespace, $stream, $field)
    {
        $this->field     = $field;
        $this->stream    = $stream;
        $this->namespace = $namespace;
    }

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get the stream namespace.
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the stream slug.
     *
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }
}
 