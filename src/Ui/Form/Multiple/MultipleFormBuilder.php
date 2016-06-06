<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
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
     * @return MultipleFormBuilder
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
     * Get a child form.
     *
     * @param $key
     * @return FormBuilder
     */
    public function getChildForm($key)
    {
        return $this->forms->get($key);
    }

    /**
     * Get the stream of a child form.
     *
     * @param $key
     * @return StreamInterface|null
     */
    public function getChildFormStream($key)
    {
        $builder = $this->getChildForm($key);

        return $builder->getFormStream();
    }

    /**
     * Get the entry of a child form.
     *
     * @param $key
     * @return EloquentModel|EntryInterface|FieldInterface|AssignmentInterface|null
     */
    public function getChildFormEntry($key)
    {
        $builder = $this->getChildForm($key);

        return $builder->getFormEntry();
    }

    /**
     * Get the entry ID of a child form.
     *
     * @param $key
     * @return int|null
     */
    public function getChildFormEntryId($key)
    {
        $builder = $this->getChildForm($key);

        return $builder->getFormEntryId();
    }

    /**
     * Get a child's entry.
     *
     * @param $key
     * @return mixed
     */
    public function getChildEntry($key)
    {
        $builder = $this->getChildForm($key);

        return $builder->getEntry();
    }

    /**
     * Get the form mode.
     *
     * @return null|string
     */
    public function getFormMode()
    {
        $form = $this->forms->first();

        return $form->getFormMode();
    }

    /**
     * Get the contextual entry ID.
     *
     * @return int|mixed|null
     */
    public function getContextualId()
    {
        /* @var FormBuilder $form */
        $form = $this->forms->first();

        return $form->getContextualId();
    }
}
