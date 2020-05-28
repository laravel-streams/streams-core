<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\View\Component;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class TableComponent
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class TableComponent extends Component
{

    /**
     * The table instance.
     *
     * @var Table
     */
    public $table;

    /**
     * Create a new TableComponent class.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Return the component view.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('streams::table/component');
    }
}
