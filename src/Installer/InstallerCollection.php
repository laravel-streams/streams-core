<?php namespace Anomaly\Streams\Platform\Installer;

use Anomaly\Streams\Platform\Support\Collection;

/**
 * Class InstallerCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer
 */
class InstallerCollection extends Collection
{

    /**
     * Add an installer ot the collection.
     *
     * @param Installer $installer
     */
    public function add(Installer $installer)
    {
        $this->push($installer);
    }
}
