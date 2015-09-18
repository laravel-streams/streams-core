<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonGuesser.
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
     * The text guesser.
     *
     * @var TextGuesser
     */
    protected $text;

    /**
     * Create a new ButtonGuesser instance.
     *
     * @param HrefGuesser $href
     * @param TextGuesser $text
     */
    public function __construct(HrefGuesser $href, TextGuesser $text)
    {
        $this->href = $href;
        $this->text = $text;
    }

    /**
     * Guess button properties.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $this->href->guess($builder);
        $this->text->guess($builder);
    }
}
