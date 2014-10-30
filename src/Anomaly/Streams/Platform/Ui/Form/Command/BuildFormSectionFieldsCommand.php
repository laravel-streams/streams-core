<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;

/**
 * Class BuildFormSectionFieldsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionFieldsCommand
{

    /**
     * The form UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUi
     */
    protected $ui;

    /**
     * The fields data.
     *
     * @var array
     */
    protected $fields;

    /**
     * Create a new BuildFormSectionFieldsCommand instance.
     *
     * @param FormUi $ui
     * @param array  $fields
     */
    function __construct(FormUi $ui, array $fields)
    {
        $this->ui     = $ui;
        $this->fields = $fields;
    }

    /**
     * Get the fields data.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get the form UI object.
     *
     * @return FormUi
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 