<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Http\Request;

/**
 * Class EnabledGuesser.
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
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();
        $mode    = $builder->getFormMode();

        foreach ($buttons as &$button) {
            if (isset($button['enabled']) && is_bool($button['enabled'])) {
                return;
            }

            switch (array_get($button, 'button')) {

                case 'delete':
                    $button['enabled'] = ($mode === 'edit');
                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
