<?php namespace Streams\Platform\Ui\Form;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    protected $ui;

    function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }


    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        return false;
    }

    public function forbiddenResponse()
    {
        return parent::forbiddenResponse();
    }
}
 