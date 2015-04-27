<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Routing\Redirector;

/**
 * Class EditActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Edit extends ActionHandler
{

    /**
     * Save the order of the entries.
     *
     * @param TableBuilder $builder
     * @param array        $selected
     */
    public function handle(Redirector $redirector, TableBuilder $builder, array $selected)
    {
        $prefix = $builder->getTableOption('prefix');

        $edit = array_shift($selected);
        $ids  = implode(',', $selected);

        $builder->setTableResponse(
            $redirector->to('admin/customers/edit/' . $edit . '?' . $prefix . 'edit_next=' . $ids)
        );
    }
}
