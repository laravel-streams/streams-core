<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

/**
 * Class Section
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section
 */
class Section implements SectionInterface
{

    /**
     * The title.
     *
     * @var null
     */
    protected $title;

    /**
     * The body content.
     *
     * @var null
     */
    protected $body;

    /**
     * The view.
     *
     * @var string
     */
    protected $view;

    /**
     * Create a new Section instance.
     *
     * @param null   $title
     * @param null   $body
     * @param string $view
     */
    public function __construct($title = null, $body = null, $view = 'streams::ui/form/sections/default/index')
    {
        $this->body  = $body;
        $this->view  = $view;
        $this->title = $title;
    }

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $title = trans($this->getTitle());

        $body = $this->getBody();

        $html = view($this->getView(), compact('title', 'body'));

        return compact('html');
    }

    /**
     * Set the body content.
     *
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the body content.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the title.
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the view.
     *
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the view.
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }
}
