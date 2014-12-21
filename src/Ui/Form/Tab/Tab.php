<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab;

use Anomaly\Streams\Platform\Ui\Form\Tab\Contract\TabInterface;

/**
 * Class Tab
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Tab
 */
class Tab implements TabInterface
{

    /**
     * The text.
     *
     * @var
     */
    protected $text;

    /**
     * Create a new Tab instance.
     *
     * @param $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return array
     */
    public function toArray()
    {
        $text = $this->getText();

        return compact('text', 'layout');
    }

    /**
     * Set the text.
     *
     * @param  $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the text.
     *
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }
}
