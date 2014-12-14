<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Interface FormModelInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormModelInterface
{
    /**
     * Find an entry or return a new instance.
     *
     * @param $id
     * @return mixed
     */
    public static function findOrNew($id);

    /**
     * Save the form input data.
     *
     * @param Form $form
     * @return mixed
     */
    public static function saveFormInput(Form $form);
}
