<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ButtonHandler
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button
 */
class ButtonHandler implements SelfHandling
{

    /**
     * Handle the buttons.
     *
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {
        if (!$section = $builder->getControlPanelActiveSection()) {
            return;
        }

        $builder->setButtons($section->getButtons());
    }
}
