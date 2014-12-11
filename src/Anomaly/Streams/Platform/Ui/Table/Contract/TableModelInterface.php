<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;

interface TableModelInterface
{
    public function getTableEntries(Table $table);
}
