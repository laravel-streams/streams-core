<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class TextGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser
 */
class TextGuesser
{

    /**
     * The button registry.
     *
     * @var ButtonRegistry
     */
    protected $buttons;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new TextGuesser instance.
     *
     * @param ButtonRegistry   $buttons
     * @param ModuleCollection $modules
     */
    public function __construct(ButtonRegistry $buttons, ModuleCollection $modules)
    {
        $this->buttons = $buttons;
        $this->modules = $modules;
    }

    /**
     * Guess the button from the hint.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        $module = $this->modules->active();

        /**
         * This will break if we can't figure
         * out what the active module is.
         */
        if (!$module instanceof Module) {
            return;
        }

        foreach ($buttons as &$button) {

            if (isset($button['text'])) {
                continue;
            }

            if (array_get($this->buttons->get(array_get($button, 'button')), 'text')) {
                continue;
            }

            if (!isset($button['text']) && isset($button['button'])) {
                $button['text'] = $module->getNamespace('button.' . $button['button']);
            }

            if (!isset($button['text']) && isset($button['button'])) {
                $button['text'] = $module->getNamespace('button.' . $button['button']);
            }
        }

        $builder->setButtons($buttons);
    }
}
