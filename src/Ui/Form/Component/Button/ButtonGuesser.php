<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\EnabledGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * The text guesser.
     *
     * @var TextGuesser
     */
    protected $text;

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
    public function __construct(HrefGuesser $href, TextGuesser $text, EnabledGuesser $enabled)
    {
        $this->href    = $href;
        $this->text    = $text;
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
        $this->text->guess($builder);
        $this->enabled->guess($builder);
    }
}
