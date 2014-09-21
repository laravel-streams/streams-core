<?php namespace Streams\Platform\Support\Contract;

interface InstallerInterface
{
    /**
     * Run the install logic.
     *
     * @return mixed
     */
    public function install();
}
