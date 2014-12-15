<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Contract;

/**
 * Interface FieldInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Field\Contract
 */
interface FieldInterface
{

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return mixed
     */
    public function viewData(array $arguments = []);

    /**
     * Set the instructions.
     *
     * @param $instructions
     * @return mixed
     */
    public function setInstructions($instructions);

    /**
     * Ge the instructions.
     *
     * @return mixed
     */
    public function getInstructions();

    /**
     * Set the placeholder.
     *
     * @param $placeholder
     * @return mixed
     */
    public function setPlaceholder($placeholder);

    /**
     * Get the placeholder.
     *
     * @return mixed
     */
    public function getPlaceholder();

    /**
     * Set the config.
     *
     * @param array $config
     * @return mixed
     */
    public function setConfig(array $config);

    /**
     * Get the config.
     *
     * @return mixed
     */
    public function getConfig();

    /**
     * Set the rules.
     *
     * @param array $rules
     * @return mixed
     */
    public function setRules(array $rules);

    /**
     * Get the rules.
     *
     * @return mixed
     */
    public function getRules();

    /**
     * Set the include flag.
     *
     * @param $include
     * @return mixed
     */
    public function setInclude($include);

    /**
     * Return the include flag.
     *
     * @return mixed
     */
    public function isInclude();

    /**
     * Set the label.
     *
     * @param $label
     * @return mixed
     */
    public function setLabel($label);

    /**
     * Get the label.
     *
     * @return mixed
     */
    public function getLabel();

    /**
     * Get the form.
     *
     * @return mixed
     */
    public function getForm();

    /**
     * Set the value.
     *
     * @param $value
     * @return mixed
     */
    public function setValue($value);

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set the slug.
     *
     * @param $slug
     * @return mixed
     */
    public function setSlug($slug);

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug();

    /**
     * Set the type.
     *
     * @param $type
     * @return mixed
     */
    public function setType($type);

    /**
     * Get the type.
     *
     * @return mixed
     */
    public function getType();
}
