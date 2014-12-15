<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Contract;

/**
 * Interface FieldsSectionInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section\Contract
 */
interface FieldsSectionInterface
{

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return mixed
     */
    public function viewData(array $arguments = []);

    /**
     * Set the fields.
     *
     * @param $fields
     * @return mixed
     */
    public function setFields($fields);

    /**
     * Get the fields.
     *
     * @return mixed
     */
    public function getFields();

    /**
     * Set the stream object.
     *
     * @param $stream
     * @return mixed
     */
    public function setStream($stream);

    /**
     * Get the stream object.
     *
     * @return mixed
     */
    public function getStream();

    /**
     * Set the entry object.
     *
     * @param $entry
     * @return mixed
     */
    public function setEntry($entry);

    /**
     * Get the entry object.
     *
     * @return mixed
     */
    public function getEntry();

    /**
     * Set the title.
     *
     * @param $title
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
     * Set the form object.
     *
     * @param $form
     * @return mixed
     */
    public function setForm($form);

    /**
     * Get the form object.
     *
     * @return mixed
     */
    public function getForm();

    /**
     * Set the view.
     *
     * @param $view
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
