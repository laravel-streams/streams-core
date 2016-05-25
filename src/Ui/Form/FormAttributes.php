<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Support\Str;

/**
 * Class FormAttributes
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormAttributes
{
    /**
     * The string utility class
     *
     * @var Str
     */
    protected $str;

    /**
     * FormAttributes constructor.
     *
     * @param Str $str
     */
    public function __construct(Str $str)
    {
        $this->str = $str;
    }

    /**
     * Make custom validation messages.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function make(FormBuilder $builder)
    {
        $attributes = [];

        /* @var FieldType $field */
        foreach ($builder->getEnabledFormFields() as $field) {

            $label = $field->getLabel();

            if (str_contains($label, '::')) {
                $label = trans($label);
            }

            if ($locale = $field->getLocale()) {
                $label .= ' (' . $locale . ')';
            }

            /**
             * If there was no label found by this point then return
             * the field name as a humanized string
             */
            if (!$label) {
               $label = $this->str->humanize($field->getFieldName());
            }

            $attributes[$field->getInputName()] = '"' . $label . '"';
        }

        return $attributes;
    }
}
