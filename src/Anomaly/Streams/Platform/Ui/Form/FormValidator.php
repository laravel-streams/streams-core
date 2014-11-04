<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

/**
 * Class FormRequest
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormValidator
{

    /**
     * Validate the form request.
     *
     * @param array $input
     */
    public function validate(Form $form, Request $request, Factory $factory)
    {
        $model = $form->getModel();
        $data  = $request->all();
        $rules = $this->localizeRules($form, $model::$rules);

        $validator = $factory->make($data, $rules);

        $this->setAttributeNames($validator, $form);

        if ($validator->passes()) {

            $form->fire('validation_passed');

            return true;
        }

        $form->setErrors($validator->messages());

        $form->fire('validation_failed');

        return false;
    }

    protected function localizeRules($form, $rules)
    {
        $localizedRules = [];

        foreach ($rules as $field => $rules) {

            if ($field == 'password') {
                continue;
            }

            $localizedRules[$form->getPrefix() . $field . '_en'] = $rules;
        }

        return $localizedRules;
    }

    protected function setAttributeNames(Validator $validator, Form $form)
    {
        $attributes = [];

        $model = $form->getModel();

        $stream = $model->getStream();

        foreach ($stream->assignments as $assignment) {

            $localized = $form->getPrefix() . $assignment->field->slug . '_en';
            
            $attributes[$localized] = strtolower($assignment->getFieldName());
        }

        $validator->setAttributeNames($attributes);
    }
}
