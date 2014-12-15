<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Type;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\FieldCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Field\FieldFactory;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\FieldsSectionInterface;

/**
 * Class FieldsSection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section\Type
 */
class FieldsSection implements FieldsSectionInterface
{

    /**
     * The view.
     *
     * @var string
     */
    protected $view;

    /**
     * The form object.
     *
     * @var
     */
    protected $form;

    /**
     * The title.
     *
     * @var null
     */
    protected $title;

    /**
     * The entry object.
     *
     * @var
     */
    protected $entry;

    /**
     * The section fields.
     *
     * @var static
     */
    protected $fields;

    /**
     * The stream object.
     *
     * @var
     */
    protected $stream;

    /**
     * The field factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Field\FieldFactory
     */
    protected $fieldFactory;

    /**
     * Create a new FieldsSection instance.
     *
     * @param array           $fields
     * @param null            $title
     * @param null            $prefix
     * @param string          $view
     * @param Form            $form
     * @param StreamInterface $stream
     * @param EntryInterface  $entry
     * @param FieldFactory    $fieldFactory
     */
    public function __construct(
        array $fields,
        $title = null,
        $prefix = null,
        $view = 'streams::ui/form/sections/fields/index',
        Form $form,
        StreamInterface $stream = null,
        EntryInterface $entry = null,
        FieldFactory $fieldFactory
    ) {
        $this->view         = $view;
        $this->title        = $title;
        $this->fieldFactory = $fieldFactory;

        foreach ($fields as &$field) {
            $field['form']   = $form;
            $field['entry']  = $entry;
            $field['stream'] = $stream;

            $field = $this->fieldFactory->make($field);
        }

        $this->fields = FieldCollection::make($fields);
    }

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $title = trans($this->title);

        $fields = [];

        foreach ($this->getFields() as $field) {
            $fields[$field->getSlug()] = $field->viewData();
        }

        $html = view($this->view, compact('title', 'fields'));

        return compact('html');
    }

    /**
     * Set the entry object.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the entry.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the fields.
     *
     * @param $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get the fields.
     *
     * @return static
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the form.
     *
     * @param $form
     * @return $this
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get the form.
     *
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set the stream.
     *
     * @param $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the stream.
     *
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the title.
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the view.
     *
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the view.
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }
}
