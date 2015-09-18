<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Routing\Redirector;

/**
 * Class EditActionHandler.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Edit extends ActionHandler implements SelfHandling
{
    /**
     * Save the order of the entries.
     *
     * @param SectionCollection $sections
     * @param TableBuilder      $builder
     * @param array             $selected
     */
    public function handle(SectionCollection $sections, Redirector $redirector, TableBuilder $builder, array $selected)
    {
        $prefix = $builder->getTableOption('prefix');

        $edit = array_shift($selected);
        $ids  = implode(',', $selected);

        if ($section = $sections->active()) {
            $builder->setTableResponse(
                $redirector->to($section->getHref('edit/'.$edit.'?'.$prefix.'edit_next='.$ids))
            );
        }
    }
}
