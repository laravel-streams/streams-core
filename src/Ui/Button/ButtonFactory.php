<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Illuminate\Support\Facades\Lang;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

/**
 * Class ButtonFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonFactory
{

    /**
     * The default button class.
     *
     * @var string
     */
    protected $button = Button::class;

    /**
     * The button registry.
     *
     * @var ButtonRegistry
     */
    protected $buttons;

    /**
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new ButtonFactory instance.
     *
     * @param ButtonRegistry $buttons
     * @param Authorizer     $authorizer
     */
    public function __construct(
        ButtonRegistry $buttons,
        Authorizer $authorizer
    ) {
        $this->buttons    = $buttons;
        $this->authorizer = $authorizer;
    }

    /**
     * Make a button.
     *
     * @param  array $parameters
     * @return ButtonInterface
     */
    public function make(array $parameters)
    {
        $button = array_get($parameters, 'button');

        if ($button && $registered = $this->buttons->get($button)) {
            $parameters = array_replace_recursive($registered, array_except($parameters, 'button'));
        }

        $parameters = Lang::translate($parameters);

        if (!array_get($parameters, 'button') || !class_exists(array_get($parameters, 'button'))) {
            array_set($parameters, 'button', $this->button);
        }

        /* @var ButtonInterface $button */
        $button = app()->make(array_get($parameters, 'button'), $parameters);

        Hydrator::hydrate($button, $parameters);

        if (($permission = $button->getPermission()) && !$this->authorizer->authorize($permission)) {
            $button->setEnabled(false);
        }

        return $button;
    }
}
