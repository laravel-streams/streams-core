<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class ReorderActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class ReorderActionHandler
{

    /**
     * Save the order of the entries.
     *
     * @param Table $table
     */
    public function handle(Table $table)
    {
        $model = $table->getModel();

        if ($model instanceof TableModelInterface) {
            $model->sortTableEntries($table);
        }

        $table->setResponse(redirect(app('request')->fullUrl()));
    }
}
