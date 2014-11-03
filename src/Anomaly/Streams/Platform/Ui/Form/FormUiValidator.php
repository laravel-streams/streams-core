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
class FormUiValidator
{

    /**
     * Validate the form request.
     *
     * @param array $input
     */
    public function validate(FormUi $ui, Request $request, Factory $factory)
    {
        $model = $ui->getModel();
        $data  = $request->all();
        $rules = $this->localizeRules($ui, $model::$rules);

        $validator = $factory->make($data, $rules);

        if ($validator->passes()) {

            $ui->fire('validation_passes');

            return true;
        }

        $messages = $validator->messages()->all();

        $ui->fire('validation_fails', compact('messages'));

        return false;
    }

    protected function localizeRules($ui, $rules)
    {
        $localizedRules = [];

        foreach ($rules as $field => $rules) {

            if ($field == 'password') {
                continue;
            }

            $localizedRules[$ui->getPrefix() . $field . '_en'] = $rules;
        }

        return $localizedRules;
    }
}
