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
     * Get input for a certain suffix.
     * Suffixes usually separate languages.
     *
     * @param Form $form
     * @param null $suffix
     * @return array
     */
    public function get(Form $form, $suffix = null)
    {
        $input = [];

        $options = $form->getOptions();

        $prefix = $options->get('prefix');

        foreach ($form->getFields() as $slug => $field) {
            $input[$slug] = $this->getFieldInput($field, $prefix, $suffix);
        }

        return $input;
    }

    /**
     * Get a field's input.
     *
     * @param FieldType $field
     * @param           $prefix
     * @param           $suffix
     * @return mixed
     */
    protected function getFieldInput(FieldType $field, $prefix, $suffix)
    {
        return $this->request->get();
    }
}
