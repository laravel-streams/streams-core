<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser;

use Illuminate\Http\Request;

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
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new RedirectGuesser instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
     * segment is either edit / create or similar and it
     * might end with a numerical ID so we can simply lop off
     * the last segment and ID leaving us with index.
     *
     * @return string
     */
    protected function guessSaveRedirect()
    {
        $segments = $this->request->segments();

        /**
         * If the last segment is an ID then remove it.
         */
        if (is_numeric(end($segments))) {
            array_pop($segments);
        }

        /**
         * If the last segment is an addon namespace
         * then remove it as well.. This is kinda cheating.
         */
        if (str_is('*.*.*', end($segments))) {
            array_pop($segments);
        }

        /**
         * Now remove the actionable
         * segment (create / edit).
         */
        array_pop($segments);

        return '/' . implode('/', $segments);
    }
}
