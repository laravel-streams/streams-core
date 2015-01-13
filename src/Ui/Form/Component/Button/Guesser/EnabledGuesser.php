<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Illuminate\Http\Request;

/**
 * Class EnabledGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser
 */
class EnabledGuesser
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new EnabledGuesser instance.
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
        /**
         * If we already have an enabled
         * status then skip it.
         */
        if (isset($button['enabled'])) {
            return;
        }

        /**
         * Determine the enabled status based on the type / URI.
         */
        switch (array_get($button, 'button')) {

            case 'delete':
                $button['enabled'] = $this->guessDeleteStatus();
                break;
        }
    }

    /**
     * Guess if the delete button is disabled.
     *
     * If the last URI segment is numerical then
     * we can assume we have an entry to delete.
     * Otherwise it's new and we can't delete it.
     *
     * @return bool
     */
    protected function guessDeleteStatus()
    {
        $segments = $this->request->segments();

        /**
         * If the last segment is an ID then remove it.
         */
        if (!is_numeric(end($segments))) {
            return false;
        }

        return true;
    }
}
