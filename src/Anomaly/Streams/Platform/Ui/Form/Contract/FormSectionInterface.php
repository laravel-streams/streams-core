<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

/**
 * Interface FormSectionInterface
 *
 * This interface helps us assure that sections being
 * sent to the form are able to return required data.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormSectionInterface
{

    /**
     * Return the heading HTML.
     *
     * @return mixed|null
     */
    public function heading();

    /**
     * Return the body HTML.
     *
     * @return mixed|null
     */
    public function body();

    /**
     * Return the footer HTML.
     *
     * @return mixed|null
     */
    public function footer();
}
 