<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Interface FormHandlerInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormHandlerInterface
{

    /**
     * Handle the form storage.
     *
     * @param Form $form
     * @return mixed
     */
    public function handle(Form $form);
}
