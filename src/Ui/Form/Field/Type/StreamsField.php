<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Type;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Field\Contract\StreamsFieldInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class StreamsField
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Field\Type
 */
class StreamsField implements StreamsFieldInterface
{

    /**
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;

    /**
     * The streams field.
     *
     * @var
     */
    protected $field;

    /**
     * The entry object.
     *
     * @var \Anomaly\Streams\Platform\Entry\Contract\EntryInterface
     */
    protected $entry;

    /**
     * The stream object.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamInterface
     */
    protected $stream;

    /**
     * Create a new StreamsField instance.
     *
     * @param                 $field
     * @param Form            $form
     * @param StreamInterface $stream
     * @param EntryInterface  $entry
     */
    public function __construct($field, Form $form, StreamInterface $stream, EntryInterface $entry = null)
    {
        $this->form   = $form;
        $this->field  = $field;
        $this->entry  = $entry;
        $this->stream = $stream;
    }

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return array
     */
    public function toArray()
    {
        $assignment = $this->stream->getAssignment($this->field);

        $type = $assignment->getFieldType($this->entry);

        $type->setPrefix($this->form->getPrefix());

        if ($assignment->isTranslatable()) {
            $input = '';

            foreach (config('streams::config.available_locales') as $locale) {
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

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->field;
    }

    /**
     * Get the entry object.
     *
     * @return EntryInterface
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the field.
     *
     * @param  $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get the field.
     *
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get the form object.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Get the stream object.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
