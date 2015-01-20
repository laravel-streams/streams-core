<?php namespace Anomaly\Streams\Platform\Contract;

/**
 * Interface Installable
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Contract
 */
interface Installable
{

    /**
     * Install.
     *
     * @return mixed
     */
    public function install();

    /**
     * Uninstall.
     *
     * @return mixed
     */
    public function uninstall();
}
