<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Http\Request;

/**
 * Class FormInput.
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
     * @var Request
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
     * Return all the input from the form.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function all(FormBuilder $builder)
    {
        $input = [];

        /* @var FieldType $field */
        foreach ($builder->getEnabledFormFields() as $field) {
            $input[$field->getInputName()] = $field->getValidationValue();
        }

        return $input;
    }
}
