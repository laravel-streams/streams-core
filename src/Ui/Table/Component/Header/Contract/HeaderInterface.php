<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract;

/**
 * Interface HeaderInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract
 */
interface HeaderInterface
{

    /**
     * Get the header heading.
     *
     * @return mixed
     */
    public function getHeading();

    /**
     * Set the header heading.
     *
     * @param $heading
     * @return $this
     */
    public function setHeading($heading);
}
