<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\HrefGuesser;

/**
 * Class ButtonGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonGuesser
{

    /**
     * The HREF guesser.
     *
     * @var HrefGuesser
     */
    protected $href;

    /**
     * Create a new ButtonGuesser instance.
     *
     * @param HrefGuesser $href
     */
    public function __construct(HrefGuesser $href)
    {
        $this->href = $href;
    }

    /**
     * Guess button properties.
     *
     * @param array $buttons
     * @return array
     */
    public function guess(array $buttons)
    {
        foreach ($buttons as &$button) {
            $this->href->guess($button);
        }

        return $buttons;
    }
}
