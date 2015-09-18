<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\EnabledGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\TypeGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ButtonGuesser.
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
     * The type guesser.
     *
     * @var TypeGuesser
     */
    protected $type;

    /**
     * The enabled guesser.
     *
     * @var EnabledGuesser
     */
    protected $enabled;

    /**
     * Create a new ButtonGuesser instance.
     *
     * @param HrefGuesser    $href
     * @param TypeGuesser    $type
     * @param EnabledGuesser $enabled
     */
    public function __construct(HrefGuesser $href, TypeGuesser $type, EnabledGuesser $enabled)
    {
        $this->href    = $href;
        $this->type    = $type;
        $this->enabled = $enabled;
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
        $this->enabled->guess($builder);
    }
}
