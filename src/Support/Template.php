<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Template
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Template
{

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

    /**
     * The file system.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Template instance.
     *
     * @param Factory     $view
     * @param Filesystem  $files
     * @param Application $application
     */
    public function __construct(Factory $view, Filesystem $files, Application $application)
    {
        $this->view        = $view;
        $this->files       = $files;
        $this->application = $application;
    }

    /**
     * Render a string template.
     *
     * @param       $template
     * @param array $payload
     * @return string
     * @throws \Exception
     */
    function render($template, array $payload = [])
    {
        $view = 'templates/' . md5($template);
        $path = $this->application->getStoragePath($view);

        if (!$this->files->isDirectory($directory = dirname($path))) {
            $this->files->makeDirectory($directory, 0777, true);
        }

        $this->files->put($path . '.twig', $template);

        return $this->view
            ->make('storage::' . $view, $payload)
            ->render();
    }
}
