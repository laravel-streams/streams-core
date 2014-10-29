<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;

/**
 * Class BuildFormSectionLayoutCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionLayoutCommand
{
    /**
     * The form UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUi
     */
    protected $ui;

    /**
     * The section data.
     *
     * @var array
     */
    protected $section;

    /**
     * Create a new BuildFormSectionLayoutCommand instance.
     *
     * @param FormUi $ui
     * @param array  $section
     */
    function __construct(FormUi $ui, array $section)
    {
        $this->ui      = $ui;
        $this->section = $section;
    }

    /**
     * Get the sections data.
     *
     * @return array
     */
    public function getSection()
    {
        return $this->section;
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
 