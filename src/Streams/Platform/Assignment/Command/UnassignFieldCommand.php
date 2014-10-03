<?php namespace Streams\Platform\Assignment\Command;

class UnassignFieldCommand
{
    /**
     * The field namespace.
     *
     * @var
     */
    protected $namespace;

    /**
     * The field stream.
     *
     * @var
     */
    protected $stream;

    /**
     * The field slug.
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
     * Get the field namespace.
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
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
     * Get the field stream.
     *
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }
}
