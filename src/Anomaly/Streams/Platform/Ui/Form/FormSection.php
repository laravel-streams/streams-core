<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;

/**
 * Class FormSection
 *
 * This is the base form section class. All form sections
 * should at least implement the interface if not extend
 * this class directly.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormSection implements FormSectionInterface
{

    use CommandableTrait;

    /**
     * The form UI object.
     *
     * @var FormUi
     */
    protected $ui;

    /**
     * The evaluated section data
     * from the UI / command handler.
     *
     * @var array
     */
    protected $section = [];

    /**
     * Create a new FormSection instance.
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
     * Return the heading HTML.
     *
     * @return mixed|null
     */
    public function heading()
    {
        return null;
    }

    /**
     * Return the body HTML.
     *
     * @return mixed|null
     */
    public function body()
    {
        return null;
    }

    /**
     * Return the footer HTML.
     *
     * @return mixed|null
     */
    public function footer()
    {
        return null;
    }

}
 