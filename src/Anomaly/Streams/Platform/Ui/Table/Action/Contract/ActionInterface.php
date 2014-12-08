<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Icon\Contract\IconInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

interface ActionInterface
{

    public function handle(Table $table, array $ids);

    public function viewData();
}
 