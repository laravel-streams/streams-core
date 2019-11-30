<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

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
     * Create a new ShortcutInput instance.
     *
     * @param ShortcutGuesser    $guesser
     * @param ModuleCollection  $modules
     */
    public function __construct(
        ShortcutGuesser $guesser,
        ModuleCollection $modules
    ) {
        $this->guesser    = $guesser;
        $this->modules    = $modules;
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

        // Defaults
        if (!$shortcuts) {
            $shortcuts = [
                'view_site' => [
                    'href'   => '/',
                    'class'  => 'button',
                    'target' => '_blank',
                    'title'  => trans('anomaly.theme.flow::control_panel.view_site')
                ],
                'logout' => [
                    'class' => 'button',
                    'href'  => 'admin/logout',
                    'title' => trans('anomaly.theme.flow::control_panel.logout')
                ],
            ];
        }

        $shortcuts = evaluate($shortcuts, compact('builder'));

        $shortcuts = $shortcuts ?: $builder->getShortcuts();

        $shortcuts = Normalizer::shortcuts($shortcuts);
        $shortcuts = Normalizer::attributes($shortcuts);
        $shortcuts = Normalizer::dropdowns($shortcuts);

        $builder->setShortcuts($shortcuts);

        $this->guesser->guess($builder);

        $shortcuts = $builder->getShortcuts();

        $shortcuts = evaluate($shortcuts, compact('builder'));
        $shortcuts = parse($shortcuts);

        $builder->setShortcuts($shortcuts);
    }
}
