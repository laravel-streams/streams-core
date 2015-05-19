<?php namespace Anomaly\Streams\Platform\Ui\Grid\Component\Button;

use Anomaly\Streams\Platform\Ui\Grid\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

/**
 * Class ButtonGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Grid\Component\Button
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
     * @param GridBuilder $builder
     */
    public function guess(GridBuilder $builder)
    {
        $this->href->guess($builder);
    }
}
