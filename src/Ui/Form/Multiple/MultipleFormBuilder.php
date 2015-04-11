<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormCollection;
use Anomaly\Streams\Platform\Ui\Form\Multiple\Command\BuildForms;
use Anomaly\Streams\Platform\Ui\Form\Multiple\Command\MergeFields;
use Illuminate\Support\Collection;

/**
 * Class MultipleFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Support
 */
class MultipleFormBuilder extends FormBuilder
{

    /**
     * The form collection.
     *
     * @var FormCollection
     */
    protected $forms;

    /**
     * Create a new MultipleFormBuilder instance.
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
        $this->dispatch(new BuildForms($this));
        $this->dispatch(new MergeFields($this));

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
     * @return $this
     */
    public function addForm($key, FormBuilder $builder)
    {
        $this->forms->put(
            $key,
            $builder
                ->setSave(false)
                ->setOption('prefix', $key . '_')
        );

        return $this;
    }

    /**
     * Get a form by it's key.
     *
     * @param $key
     * @return FormBuilder
     */
    public function getForm($key)
    {
        return $this->forms->get($key);
    }
}
