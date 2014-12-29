<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;

/**
 * Class View
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class View implements ViewInterface
{

    /**
     * The view slug.
     *
     * @var string
     */
    protected $slug;

    /**
     * The view text.
     *
     * @var string
     */
    protected $text;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active;

    /**
     * The view prefix.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Get the view URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return url(app('request')->path()) . '?' . $this->prefix . 'view=' . $this->slug;
    }

    /**
     * Set the active flag.
     *
     * @param bool $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Get the view slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the view text.
     *
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the view text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
