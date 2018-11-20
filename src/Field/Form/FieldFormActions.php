<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class FieldFormActions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldFormActions
{

    /**
     * Handle the actions.
     *
     * @param FieldFormBuilder $builder
     * @param ControlPanelBuilder $cp
     */
    public function handle(FieldFormBuilder $builder, ControlPanelBuilder $cp)
    {
        $choose = $cp->getActiveControlPanelSectionHref('choose');

        $builder->setActions(
            [
                'save'        => [
                    'enabled' => 'create',
                ],
                'save_create' => [
                    'enabled'  => 'create',
                    'redirect' => $cp->getActiveControlPanelSectionHref('#click:[href="' . $choose . '"]'),
                ],
                'update'      => [
                    'enabled' => 'edit',
                ],
                'save_exit'   => [
                    'enabled' => 'edit',
                ],
            ]
        );
    }
}
