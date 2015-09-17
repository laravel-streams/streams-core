<?php

namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Interface FormRepositoryInterface.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormRepositoryInterface
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
     * @param FormBuilder $builder
     * @return bool|mixed
     */
    public function save(FormBuilder $builder);
}
