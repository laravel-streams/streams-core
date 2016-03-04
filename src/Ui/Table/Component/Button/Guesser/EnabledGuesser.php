<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class EnabledGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser
 */
class EnabledGuesser
{

    /**
     * The authorizer service.
     *
     * @var Authorizer
     */
    protected $authorizer;


    /**
     * Create a new EnabledGuesser instance.
     *
     * @param Authorizer $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * Guess the HREF for a button.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as &$button) {
            if (isset($button['permission']) && !$this->authorizer->authorize($button['permission'])) {
                $button['enabled'] = false;
            }
        }

        $builder->setButtons($buttons);
    }
}
