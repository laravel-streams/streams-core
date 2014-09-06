<?php namespace Streams\Core\Http\Controller;

use Composer\Autoload\ClassLoader;

class InstallerController extends BaseController
{
    /**
     * The installer steps.
     *
     * @var array
     */
    protected $steps = [
        'system',
        'database',
        'administration',
        'modules',
        'extensions',
        'themes',
        'blocks',
        'tags',
        'install',
    ];

    /**
     * Class loader
     *
     * @var \Composer\Autoload\ClassLoader
     */
    protected $loader;

    /**
     * Installer handler
     *
     * @var \Installer\Installer
     */
    protected $installer;

    /**
     * Create a new InstallerController instance
     */
    public function __construct()
    {
        // Check if Streams is installed.
        if (!\Application::installerExists()) {
            return \Redirect::to('/');
        }

        \View::addNamespace('installer', base_path('installer/views'));
    }

    /**
     * Run an installer step.
     *
     * @param string $step
     * @return \Illuminate\Http\RedirectResponse
     */
    public function run($step = null)
    {
        if (!in_array($step, $this->steps)) {
            return \Redirect::to('/installer/' . array_shift($this->steps));
        }

        $method = camel_case($step);

        return call_user_func_array([$this, $method], []);
    }

    /**
     * Get the step after the given step.
     *
     * @param $step
     * @return mixed
     */
    protected function next($step)
    {
        return $this->steps[array_search(\Str::snake($step), $this->steps)+1];
    }

    /**
     * Get the step before the given step.
     *
     * @param $step
     * @return mixed
     */
    protected function previous($step)
    {
        return $this->steps[array_search(\Str::snake($step), $this->steps)-1];
    }
}
