<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;

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
     * The form UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUi
     */
    protected $ui;

    /**
     * The columns data.
     *
     * @var array
     */
    protected $columns;

    /**
     * Create a new BuildFormSectionColumnsCommand instance.
     *
     * @param FormUi $ui
     * @param array  $columns
     */
    function __construct(FormUi $ui, array $columns)
    {
        $this->ui      = $ui;
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
     * Get the form UI object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Form\FormUi
     */
    public function getUi()
    {
        return $this->ui;
    }

}
 