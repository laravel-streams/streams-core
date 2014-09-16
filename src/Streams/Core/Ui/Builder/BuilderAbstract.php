<?php namespace Streams\Core\Ui\Builder;

use Streams\Core\Ui\Contract\BuilderInterface;

abstract class BuilderAbstract implements BuilderInterface
{
    /**
     * The builder options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * Set the options.
     *
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Set the entry.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Return data.
     *
     * @return null
     */
    public function data()
    {
        return null;
    }
}