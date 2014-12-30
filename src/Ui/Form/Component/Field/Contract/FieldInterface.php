<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Contract;

/**
 * Interface FieldInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Field\Contract
 */
interface FieldInterface
{

    /**
     * Set the config.
     *
     * @param  array $config
     * @return $this
     */
    public function setConfig(array $config);

    /**
     * Get the config.
     *
     * @return array
     */
    public function getConfig();

    /**
     * Set the instructions.
     *
     * @param string $instructions
     * @return $this
     */
    public function setInstructions($instructions);

    /**
     * Get the instructions.
     *
     * @return string
     */
    public function getInstructions();

    /**
     * Set the label.
     *
     * @param string $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Set the placeholder.
     *
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder);

    /**
     * Get the placeholder.
     *
     * @return string
     */
    public function getPlaceholder();

    /**
     * Set the rules.
     *
     * @param  array $rules
     * @return $this
     */
    public function setRules(array $rules);

    /**
     * Get the rules.
     *
     * @return array
     */
    public function getRules();

    /**
     * Set the slug.
     *
     * @param string $slug
     * @return $this
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
     * @param mixed $type
     * @return $this
     */
    public function setType($type);

    /**
     * Get the type.
     *
     * @return mixed
     */
    public function getType();

    /**
     * Set the value.
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value);

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue();
}
