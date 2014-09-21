<?php namespace Streams\Platform\Ui\Support;

use Streams\Platform\Traits\CallableTrait;
use Streams\Platform\Ui\Contract\FormActionInterface;

class FormAction implements FormActionInterface
{
    use CallableTrait;

    /**
     * The view slug.
     *
     * @var null
     */
    protected $slug = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The views options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Create a new TableView instance.
     *
     * @param         $options
     */
    public function __construct($options)
    {
        if (isset($options['callbacks'])) {
            $this->callbacks = $options['callbacks'];

            unset($options['callbacks']);
        }

        $this->options = $options;
    }

    /**
     * Redirect the request.
     *
     * @param $entry
     */
    public function redirect($entry)
    {
        if ($redirect = evaluate($this->getOption('redirect'), [$entry])) {
            \Messages::flash();

            header('Location: ' . url($redirect));
        }
    }

    /**
     * Return an option value.
     *
     * @param      $option
     * @param null $default
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return isset($this->options[$option]) ? $this->options[$option] : $default;
    }

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the active state.
     *
     * @param $state
     * @return $this|mixed
     */
    public function setActive($state)
    {
        $this->active = $state;

        return $this;
    }

    /**
     * Return the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return ($this->active);
    }
}