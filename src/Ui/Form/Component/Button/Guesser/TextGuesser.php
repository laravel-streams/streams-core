<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Translation\Translator;

/**
 * Class TextGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TextGuesser
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The string utility.
     *
     * @var Str
     */
    protected $string;

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
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new TextGuesser instance.
     *
     * @param Str              $string
     * @param Repository       $config
     * @param ButtonRegistry   $buttons
     * @param ModuleCollection $modules
     * @param Translator       $translator
     */
    public function __construct(
        Str $string,
        Repository $config,
        ButtonRegistry $buttons,
        ModuleCollection $modules,
        Translator $translator
    ) {
        $this->config     = $config;
        $this->string     = $string;
        $this->buttons    = $buttons;
        $this->modules    = $modules;
        $this->translator = $translator;
    }

    /**
     * Guess the button from the hint.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        $module = $this->modules->active();

        /*
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

            if (!isset($button['button'])) {
                continue;
            }

            $text = $module->getNamespace('button.' . $button['button']);

            if (!isset($button['text']) && $this->translator->has($text)) {
                $button['text'] = $text;
            }

            if (
                (!isset($button['text']) || !$this->translator->has($button['text']))
                && $this->config->get('streams::system.lazy_translations')
            ) {
                $button['text'] = ucwords($this->string->humanize($button['button']));
            }

            if (!isset($button['text'])) {
                $button['text'] = $text;
            }
        }

        $builder->setButtons($buttons);
    }
}
