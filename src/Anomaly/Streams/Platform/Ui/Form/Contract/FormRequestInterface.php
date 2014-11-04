<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\Form;

interface FormRequestInterface
{

    public function __construct(Form $form);

    public function validate(array $input);

    public function authorize(array $input);
}
 