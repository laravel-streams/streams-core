<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\View\Component;

/**
 * Class TableComponent
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class TableComponent extends Component
{

    public $table;

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
        return view('streams::components.table');
    }
}
