<?php namespace Anomaly\Streams\Platform\Assignment\Form;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

class AssignmentFormActions
{

    public function handle(AssignmentFormBuilder $builder, ControlPanelBuilder $cp)
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
