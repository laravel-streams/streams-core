<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormCollection;
use Anomaly\Streams\Platform\Ui\Form\Multiple\Command\BuildForms;
use Anomaly\Streams\Platform\Ui\Form\Multiple\Command\HandleErrors;
use Anomaly\Streams\Platform\Ui\Form\Multiple\Command\MergeFields;
use Anomaly\Streams\Platform\Ui\Form\Multiple\Command\PostForms;

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
    }

    /**
     * Build the form.
     *
     * @param null $entry
     */
    public function build($entry = null)
    {
        $this->dispatch(new BuildForms($this));
        $this->dispatch(new PostForms($this));
        $this->dispatch(new MergeFields($this));
        $this->dispatch(new HandleErrors($this));

        parent::build($entry);
    }

    /**
     * Save the forms.
     */
    public function saveForm()
    {
        $this->fire('saving', ['builder' => $this]);
        
        /* @var FormBuilder $builder */
        foreach ($forms = $this->getForms() as $slug => $builder) {

            $this->fire('saving_' . $slug, compact('builder', 'forms'));

            $builder->saveForm();

            $this->fire('saved_' . $slug, compact('builder', 'forms'));
        }

        $this->fire('saved', ['builder' => $this]);
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
}
