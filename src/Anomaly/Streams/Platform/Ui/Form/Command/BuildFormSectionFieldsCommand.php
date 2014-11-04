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
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;

    /**
     * The fields data.
     *
     * @var array
     */
    protected $fields;

    /**
     * Create a new BuildFormSectionFieldsCommand instance.
     *
     * @param Form $form
     * @param array  $fields
     */
    function __construct(Form $form, array $fields)
    {
        $this->form     = $form;
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
    public function getForm()
    {
        return $this->form;
    }
}
 