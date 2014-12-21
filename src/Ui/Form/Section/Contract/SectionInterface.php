<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Contract;

/**
 * Interface SectionInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Section\Contract
 */
interface SectionInterface
{

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return mixed
     */
    public function toArray();

    /**
     * Set the body content.
     *
     * @param  $body
     * @return mixed
     */
    public function setBody($body);

    /**
     * Get the body content.
     *
     * @return mixed
     */
    public function getBody();

    /**
     * Set the title.
     *
     * @param  $title
     * @return mixed
     */
    public function setTitle($title);

    /**
     * Get the title.
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * Set the view.
     *
     * @param  $view
     * @return mixed
     */
    public function setView($view);

    /**
     * Get the view.
     *
     * @return mixed
     */
    public function getView();
}
