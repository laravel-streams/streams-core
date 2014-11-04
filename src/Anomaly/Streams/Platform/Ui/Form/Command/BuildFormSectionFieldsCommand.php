<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

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
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
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
     * @param Form $ui
     * @param array  $fields
     */
    function __construct(Form $ui, array $fields)
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
     * @return Form
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 