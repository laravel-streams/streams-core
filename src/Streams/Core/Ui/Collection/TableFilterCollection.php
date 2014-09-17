<?php namespace Streams\Core\Ui\Collection;

use Streams\Core\Ui\TableUi;
use Streams\Core\Support\Collection;
use Streams\Core\Ui\Support\TableFilter;
use Streams\Core\Ui\Contract\TableFilterInterface;
use Streams\Core\Ui\Contract\TableViewInterface;

class TableFilterCollection extends Collection
{
    /**
     * Create a new TableFilterCollection instance.
     *
     * @param TableUi $ui
     * @param array   $items
     */
    public function __construct(TableUi $ui, $items = [])
    {
        foreach ($items as &$item) {
            if (!$item instanceof TableFilterInterface) {
                $item = new TableFilter($ui, $item);
            }
        }

        parent::__construct($items);
    }
}