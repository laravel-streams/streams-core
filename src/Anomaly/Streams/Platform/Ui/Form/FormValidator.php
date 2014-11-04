<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

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

        if ($validator->passes()) {

            $form->fire('validation_passes');

            return true;
        }

        $messages = $validator->messages()->all();

        $form->fire('validation_fails', compact('messages'));

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
}
