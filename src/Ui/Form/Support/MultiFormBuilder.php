<?php namespace Anomaly\Streams\Platform\Ui\Form\Support;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormCollection;
use Illuminate\Support\Collection;

/**
 * Class MultiFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Support
 */
class MultiFormBuilder extends FormBuilder
{

    /**
     * The form collection.
     *
     * @var FormCollection
     */
    protected $forms;

    /**
     * Create a new MultiFormBuilder instance.
     *
     * @param Form           $form
     * @param FormCollection $forms
     */
    public function __construct(Form $form, FormCollection $forms)
    {
        $this->forms = $forms;

        parent::__construct($form);

        $this->fire('init', ['builder' => $this]);
    }

    /**
     * Build the form.
     *
     * @param null $entry
     */
    public function build($entry = null)
    {
        parent::build($entry);
    }

    /**
     * Make the form.
     *
     * @param null $entry
     */
    public function make($entry = null)
    {
        parent::make($entry);
    }

    /**
     * Save the form.
     */
    public function saveForm()
    {
        die('Saving!');
    }

    /**
     * Get the forms.
     *
     * @return FormCollection
     */
    public function getForms()
    {
        return $this->forms;
    }

    /**
     * Set the forms.
     *
     * @param $forms
     * @return $this
     */
    public function setForms(FormCollection $forms)
    {
        $this->forms = $forms;

        return $this;
    }

    /**
     * Add a form.
     *
     * @param             $key
     * @param FormBuilder $builder
     */
    public function addForm($key, FormBuilder $builder)
    {
        $this->forms->put($key, $builder);
    }
}
