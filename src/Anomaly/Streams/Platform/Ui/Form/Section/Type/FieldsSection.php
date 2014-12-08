<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Type;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\FieldCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Field\FieldFactory;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;

class FieldsSection implements SectionInterface
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

    public function viewData()
    {
        $title = trans($this->title);

        $fields = [];

        foreach ($this->fields as $field) {

            $fields[$field->getSlug()] = $field->viewData();
        }

        $html = view($this->view, compact('title', 'fields'));

        return compact('html');
    }
}
 