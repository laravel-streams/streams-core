<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/**
 * Class HrefGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser
 */
class HrefGuesser
{

    /**
     * The router object.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new HrefGuesser instance.
     *
     * @param Request $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Guess the HREF for a button.
     *
     * @param array $button
     */
    public function guess(array &$button)
    {
        // If we already have an HREF then skip it.
        if (isset($button['attributes']['href'])) {
            return;
        }

        // Determine the HREF based on the button type.
        switch (array_get($button, 'button')) {

            case 'edit':
                $button['attributes']['href'] = $this->guessEditHref();
                break;

            case 'delete':
                $button['attributes']['href'] = $this->guessDeleteHref();
                break;
        }
    }

    /**
     * Guess the edit URL.
     *
     * Since this is for tables we can assume
     * and SHOULD assume this is the index so
     * we can simply append the action and the ID.
     *
     * @return string
     */
    protected function guessEditHref()
    {
        $route = $this->router->getCurrentRoute();

        return '/' . $route->getPath() . '/edit/{{ entry.id }}';
    }

    /**
     * Guess the delete URL.
     *
     * Since this is for tables we can assume
     * and SHOULD assume this is the index so
     * we can simply append the action and the ID.
     *
     * @return string
     */
    protected function guessDeleteHref()
    {
        $route = $this->router->getCurrentRoute();

        return '/' . $route->getPath() . '/delete/{{ entry.id }}';
    }
}
