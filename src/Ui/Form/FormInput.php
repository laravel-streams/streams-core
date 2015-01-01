<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Http\Request;

/**
 * Class FormInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormInput
{

    /**
     * The request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new FormInput instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get input for a certain locale.
     * Suffixes usually separate languages.
     *
     * @param Form $form
     * @param null $locale
     * @return array
     */
    public function get(Form $form, $locale = null)
    {
        $input = [];

        foreach ($form->getFields() as $slug => $field) {
            $input[$slug] = $this->getFieldInput($field, $locale);
        }

        return $input;
    }

    /**
     * Get a field's input.
     *
     * @param FieldType $field
     * @param           $locale
     * @return mixed
     */
    protected function getFieldInput(FieldType $field, $locale)
    {
        $field->setLocale($locale);

        return $this->request->input($field->getFieldName());
    }
}
