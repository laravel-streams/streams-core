<?php namespace Streams\Platform\Support;

use Streams\Platform\Traits\CallableTrait;

class Installer
{
    use CallableTrait;

    /**
     * Run through installation steps.
     *
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * Uninstall method.
     *
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    /**
     * Abort the installation.
     *
     * @return bool
     */
    protected function abort()
    {
        return $this->uninstall();
    }
}
