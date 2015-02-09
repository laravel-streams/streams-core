<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\Form;
use Illuminate\Http\Request;

/**
 * Interface FormRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormRepository
{

    /**
     * Find an entry or return a new one.
     *
     * @param $id
     * @return mixed
     */
    public function findOrNew($id);

    /**
     * Save the form.
     *
     * @param Form $form
     * @return bool|mixed
     */
    public function save(Form $form);
}
