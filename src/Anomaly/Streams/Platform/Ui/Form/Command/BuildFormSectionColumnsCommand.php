<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class BuildFormSectionColumnsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionColumnsCommand
{

    /**
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;

    /**
     * The columns data.
     *
     * @var array
     */
    protected $columns;

    /**
     * Create a new BuildFormSectionColumnsCommand instance.
     *
     * @param Form  $form
     * @param array $columns
     */
    function __construct(Form $form, array $columns)
    {
        $this->form    = $form;
        $this->columns = $columns;
    }

    /**
     * Get the columns data.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Get the form object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
 