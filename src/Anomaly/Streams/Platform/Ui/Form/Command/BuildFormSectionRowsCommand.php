<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class BuildFormSectionRowsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionRowsCommand
{

    /**
     * The form UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $ui;

    /**
     * The section rows configuration.
     *
     * @var array
     */
    protected $rows;

    /**
     * Create a new BuildFormSectionRowsCommand instance.
     *
     * @param Form $ui
     * @param array  $rows
     */
    function __construct(Form $ui, array $rows)
    {
        $this->ui   = $ui;
        $this->rows = $rows;
    }

    /**
     * Get the section rows configuration.
     *
     * @return mixed
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Get the form UI object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Form\Form
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 