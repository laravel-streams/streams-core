<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Type;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\FieldCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Field\FieldFactory;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\FieldsSectionInterface;

class FieldsSection implements FieldsSectionInterface
{

    protected $view;

    protected $form;

    protected $title;

    protected $entry;

    protected $fields;

    protected $stream;

    protected $fieldFactory;

    function __construct(
        array $fields,
        $title = null,
        $prefix = null,
        $view = 'ui/form/sections/fields/index',
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

    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }
}
 