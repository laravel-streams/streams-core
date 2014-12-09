<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Type;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Field\Contract\StreamsFieldInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

class StreamsField implements StreamsFieldInterface
{

    protected $form;

    protected $field;

    protected $entry;

    protected $stream;

    function __construct($field, Form $form, StreamInterface $stream, EntryInterface $entry = null)
    {
        $this->form   = $form;
        $this->field  = $field;
        $this->entry  = $entry;
        $this->stream = $stream;
    }

    public function viewData(array $arguments = [])
    {
        $assignment = $this->stream->getAssignment($this->field);

        $type = $assignment->getFieldType($this->entry);

        $type->setPrefix($this->form->getPrefix());

        if ($assignment->isTranslatable()) {

            $input = '';

            foreach (config('streams.available_locales') as $locale) {

                $type->setSuffix($locale);
                $type->setLocale($locale);
                $type->setHidden($locale !== config('app.locale'));

                $key = $this->form->getPrefix() . $assignment->getFieldSlug() . '_' . $locale;

                if (app('request')->exists($key)) {

                    $type->setValue(app('request')->get($key));
                }

                $input .= $type->render();
            }
        } else {

            $type->setSuffix(config('app.locale'));
            $type->setLocale(config('app.locale'));

            $key = $this->form->getPrefix() . $assignment->getFieldSlug() . '_' . config('app.locale');

            if (app('request')->exists($key)) {

                $type->setValue(app('request')->get($key));
            }

            $input = $type->render();
        }

        return compact('input');
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function getStream()
    {
        return $this->stream;
    }
}
 