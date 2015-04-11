<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\EnabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button
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
     * The enabled guesser.
     *
     * @var EnabledGuesser
     */
    protected $enabled;

    /**
     * Create a new ButtonGuesser instance.
     *
     * @param HrefGuesser    $href
     * @param EnabledGuesser $enabled
     */
    public function __construct(HrefGuesser $href, EnabledGuesser $enabled)
    {
        $this->href    = $href;
        $this->enabled = $enabled;
    }

    /**
     * Guess button properties.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $this->href->guess($builder);
        $this->enabled->guess($builder);
    }
}
