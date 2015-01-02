<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TablePluginFunctions
 *
 * @link          http://anomaly.is/streams-plattable
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platforma\Ui\Table
 */
class TablePluginFunctions
{

    use CommanderTrait;

    /**
     * Render the table's views.
     *
     * @param Table $table
     * @return \Illuminate\View\View
     */
    public function views(Table $table)
    {
        $options = $table->getOptions();

        return view($options->get('views_view', 'streams::ui/table/partials/views'), compact('table'));
    }

    /**
     * Render the table's filters.
     *
     * @param Table $table
     * @return \Illuminate\View\View
     */
    public function filters(Table $table)
    {
        $options = $table->getOptions();

        return view($options->get('filters_view', 'streams::ui/table/partials/filters'), compact('table'));
    }

    /**
     * Render the table's header.
     *
     * @param Table $table
     * @return \Illuminate\View\View
     */
    public function header(Table $table)
    {
        $options = $table->getOptions();

        return view($options->get('header_view', 'streams::ui/table/partials/header'), compact('table'));
    }

    /**
     * Render the table's body.
     *
     * @param Table $table
     * @return \Illuminate\View\View
     */
    public function body(Table $table)
    {
        $options = $table->getOptions();

        return view($options->get('body_view', 'streams::ui/table/partials/body'), compact('table'));
    }

    /**
     * Render the table's footer.
     *
     * @param Table $table
     * @return \Illuminate\View\View
     */
    public function footer(Table $table)
    {
        $options = $table->getOptions();

        return view($options->get('footer_view', 'streams::ui/table/partials/footer'), compact('table'));
    }

    /**
     * Return a column heading value.
     *
     * @param Table           $table
     * @param ColumnInterface $column
     * @return string
     */
    public function heading(Table $table, ColumnInterface $column)
    {
        return $this->execute(
            '\Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\GetColumnHeadingCommand',
            compact('table', 'column')
        );
    }

    /**
     * Return a column data value.
     *
     * @param Table           $table
     * @param ColumnInterface $column
     * @param                 $entry
     * @return string
     */
    public function column(Table $table, ColumnInterface $column, $entry)
    {
        return $this->execute(
            '\Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\GetColumnValueCommand',
            compact('table', 'column', 'entry')
        );
    }
}
