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
     * Save form input.
     *
     * @param Form $form
     * @return mixed
     */
    public function saveFormInput(Form $form);

    /**
     * Find an entry or return a new one.
     *
     * @param $id
     * @return mixed
     */
    public static function findOrNew($id);
}
