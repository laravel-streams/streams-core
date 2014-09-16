<?php namespace Streams\Core\Support\Contract;

interface InstallerInterface
{
    /**
     * Run the install logic.
     *
     * @return mixed
     */
    public function install();
}
