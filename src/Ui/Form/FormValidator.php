<?php namespace Anomaly\Streams\Platform\Ui\Form;

/**
 * Class FormValidator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormValidator
{

    /**
     * The form input utility.
     *
     * @var FormInput
     */
    protected $input;

    /**
     * Create a new FormValidator instance.
     *
     * @param FormInput $input
     */
    public function __construct(FormInput $input)
    {
        $this->input = $input;
    }

    /**
     * Validate a form's input.
     *
     * @param Form $form
     */
    public function validate(Form $form)
    {
        $fields = $form->getFields();

        print_r($this->input->get($form, config('app.locale')));
        die;
    }
}
