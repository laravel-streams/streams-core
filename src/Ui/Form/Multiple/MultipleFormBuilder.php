<?php namespace Anomaly\Streams\Platform\Ui\Form\Multiple;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldCollection;
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
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * @return $this
     */
    public function build($entry = null)
    {
        $this->fire('ready', ['builder' => $this]);

        $this->dispatch(new BuildForms($this));
        $this->dispatch(new MergeFields($this));

        parent::build($entry);

        $this->fire('built', ['builder' => $this]);

        return $this;
    }

    /**
     * Post the form.
     *
     * @return $this
     */
    public function post()
    {
        if (app('request')->isMethod('post')) {
            $this->dispatch(new PostForms($this));
            $this->dispatch(new HandleErrors($this));
        }

        parent::post();

        return $this;
    }

    /**
     * Validate child forms.
     *
     * @return $this
     */
    public function validate()
    {
        $this->forms->map(
            function ($form) {

                /* @var FormBuilder $form */
                $form->validate();
            }
        );

        $this->dispatch(new HandleErrors($this));

        return $this;
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
     * @param                      $key
     * @param  FormBuilder         $builder
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
     * Get the form field slugs.
     *
     * @param $key
     * @return FieldCollection
     */
    public function getChildFormFields($key)
    {
        $builder = $this->getChildForm($key);

        return $builder->getFormFields();
    }

    /**
     * Get the form field slugs.
     *
     * @param      $key
     * @param null $prefix
     * @return array
     */
    public function getChildFormFieldSlugs($key, $prefix = null)
    {
        $builder = $this->getChildForm($key);

        return $builder->getFormFieldSlugs($prefix);
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
