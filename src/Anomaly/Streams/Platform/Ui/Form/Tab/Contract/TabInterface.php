<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab\Contract;

/**
 * Interface TabInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Tab\Contract
 */
interface TabInterface
{
    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return mixed
     */
    public function viewData(array $arguments = []);

    /**
     * Set the text.
     *
     * @param $text
     * @return mixed
     */
    public function setText($text);

    /**
     * Get the text.
     *
     * @return mixed
     */
    public function getText();
}
