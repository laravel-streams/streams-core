<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Illuminate\Http\Request;

/**
 * Class HrefGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser
 */
class HrefGuesser
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new HrefGuesser instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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

            case 'cancel':
                $button['attributes']['href'] = $this->guessCancelHref();
                break;

            case 'delete':
                $button['attributes']['href'] = $this->guessDeleteHref();
                break;
        }
    }

    /**
     * Guess the cancel URL.
     *
     * Since this is for a form we can assume the last
     * segment is either edit / create or similar and it
     * might end with an integer ID so we can simply lop off
     * the last segment and ID leaving us with index.
     *
     * @return string
     */
    protected function guessCancelHref()
    {
        $segments = $this->request->segments();

        /**
         * If the last segment is an ID then remove it.
         */
        if (is_numeric(end($segments))) {
            array_pop($segments);
        }

        /**
         * Now remove the actionable
         * segment (create / edit).
         */
        array_pop($segments);

        return '/' . implode('/', $segments);
    }

    /**
     * Guess the delete URL.
     *
     * Since this is for tables we can assume the
     * last segment is index so we can simply append
     * the action and the ID.
     *
     * @return string
     */
    protected function guessDeleteHref()
    {
        $segments = $this->request->segments();

        return $this->guessCancelHref() . '/delete/' . end($segments);
    }
}
