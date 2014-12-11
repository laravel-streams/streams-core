<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\Form;

interface FormModelInterface
{
    public static function findOrNew($id);

    public static function saveFormInput(Form $form);
}
