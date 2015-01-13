<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser;

use Illuminate\Routing\Router;

/**
 * Class RedirectGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser
 */
class RedirectGuesser
{

    /**
     * The router object.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new RedirectGuesser instance.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Guess the action redirect.
     *
     * @param array $action
     */
    public function guess(array &$action)
    {
        // If we already have an HREF then skip it.
        if (isset($action['redirect'])) {
            return;
        }

        // Determine the HREF based on the action type.
        switch (array_get($action, 'action')) {

            case 'save':
                $action['redirect'] = $this->guessSaveRedirect();
                break;
        }
    }

    /**
     * Guess the save redirect.
     *
     * Since this is for a form we can assume the last
     * segment is either edit / create or something so we
     * can simply lop off the last segment (becoming index).
     *
     * @return string
     */
    protected function guessSaveRedirect()
    {
        $route = $this->router->getCurrentRoute();

        $path = $route->getPath();

        return '/' . substr($path, 0, strrpos($path, '/'));
    }
}
