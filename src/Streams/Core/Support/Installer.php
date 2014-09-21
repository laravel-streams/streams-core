<?php namespace Streams\Platform\Support;

use Streams\Platform\Traits\CallableTrait;

class Installer
{
    use CallableTrait;

    /**
     * Installation steps.
     *
     * @var array
     */
    protected $steps = [];

    /**
     * Run through installation steps.
     *
     * @return bool
     */
    public function install()
    {
        $this->fire('before_install');

        foreach ($this->steps as $step) {
            $this->run($step);
        }

        $this->fire('after_install');

        return true;
    }

    /**
     * Run an install method.
     *
     * @param $step
     * @return mixed
     */
    protected function run($step)
    {
        $method = camel_case($step);

        return call_user_func_array([$this, $method], []);
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

    /**
     * Get the steps array.
     *
     * @return array
     */
    public function getSteps()
    {
        return $this->steps;
    }
}
