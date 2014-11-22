<?php namespace Anomaly\Streams\Platform\Contract;

/**
 * Interface InstallableInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Contract
 */
interface InstallableInterface
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
 