<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\FormUi;

interface FormRequestInterface
{

    public function __construct(FormUi $ui);

    public function validate(array $input);

    public function authorize(array $input);
}
 