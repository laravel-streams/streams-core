<?php namespace Streams\Platform\Ui\Form;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * @var FormUi
     */
    protected $ui;

    /**
     * @param FormUi $ui
     */
    function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * @return mixed
     */
    public function rules()
    {
        $model = $this->ui->getModel();

        return $model::$rules;
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        return parent::forbiddenResponse();
    }
}
 