<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ShortcutInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutInput
{

    /**
     * The shortcut parser.
     *
     * @var ShortcutParser
     */
    protected $parser;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The shortcut guesser.
     *
     * @var ShortcutGuesser
     */
    protected $guesser;

    /**
     * The shortcut evaluator.
     *
     * @var ShortcutEvaluator
     */
    protected $evaluator;

    /**
     * The shortcut normalizer.
     *
     * @var ShortcutNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ShortcutInput instance.
     *
     * @param ShortcutParser     $parser
     * @param ShortcutGuesser    $guesser
     * @param ModuleCollection  $modules
     * @param ShortcutEvaluator  $evaluator
     * @param ShortcutNormalizer $normalizer
     */
    public function __construct(
        ShortcutParser $parser,
        ShortcutGuesser $guesser,
        ModuleCollection $modules,
        ShortcutEvaluator $evaluator,
        ShortcutNormalizer $normalizer
    ) {
        $this->parser     = $parser;
        $this->guesser    = $guesser;
        $this->modules    = $modules;
        $this->evaluator  = $evaluator;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the shortcut input and process it
     * before building the objects.
     *
     * @param ControlPanelBuilder $builder
     */
    public function read(ControlPanelBuilder $builder)
    {
        $shortcuts = $builder->getShortcuts();

        $shortcuts = resolver($shortcuts, compact('builder'));

        $shortcuts = $shortcuts ?: $builder->getShortcuts();

        $builder->setShortcuts($shortcuts);

        // Defaults
        if (!$builder->getShortcuts()) {
            $builder->setShortcuts([
                'view_site' => [
                    'href'   => '/',
                    'target' => '_blank',
                    'title' => trans('anomaly.theme.flow::control_panel.view_site')
                ],
                'logout' => [
                    'href'  => 'admin/logout',
                    'title' => trans('anomaly.theme.flow::control_panel.logout')
                ],
            ]);
        }

        $this->evaluator->evaluate($builder);
        $this->normalizer->normalize($builder);
        $this->guesser->guess($builder);
        $this->evaluator->evaluate($builder);
        $this->parser->parse($builder);
    }
}
