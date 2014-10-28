<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

/**
 * Interface FormServiceInterface
 *
 * This interface helps assure that the form service
 * being used can at least return the required data.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormServiceInterface
{

    /**
     * Return the sections data.
     *
     * @return mixed
     */
    public function sections();

    /**
     * Return the redirects data.
     *
     * @return mixed
     */
    public function redirects();

}
 