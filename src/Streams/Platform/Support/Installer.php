<?php namespace Streams\Platform\Support;

use Laracasts\Commander\CommanderTrait;
use Streams\Platform\Traits\CallableTrait;

class Installer
{
    use CallableTrait;
    use CommanderTrait;

    /**
     * Install logic.
     *
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * Uninstall logic.
     *
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}
