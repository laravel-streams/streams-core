<?php namespace Anomaly\Streams\Platform\Installer;

use Anomaly\Streams\Platform\Support\Collection;

/**
 * Class InstallerCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
