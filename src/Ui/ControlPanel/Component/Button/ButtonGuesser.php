<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\TypeGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ButtonGuesser
 *
 * @link          http://anomaly.is/streams-Platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button
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
     * @var TypeGuesser
     */
    protected $type;

    /**
     * Create a new ButtonGuesser instance.
     *
     * @param HrefGuesser $href
     * @param TypeGuesser $type
     */
    public function __construct(HrefGuesser $href, TypeGuesser $type)
    {
        $this->href = $href;
        $this->type = $type;
    }

    /**
     * Guess button properties.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $this->type->guess($builder);
        $this->href->guess($builder);
    }
}
