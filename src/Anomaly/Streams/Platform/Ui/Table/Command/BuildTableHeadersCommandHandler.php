<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class BuildTableHeadersCommandHandler
{
    public function handle(BuildTableHeadersCommand $command)
    {
        $ui = $command->getUi();

        $columns = evaluate($ui->getColumns(), [$ui]);

        foreach ($columns as &$column) {

            $title = $this->makeTitle($column, $ui);

            $column = compact('title');

        }

        return $columns;
    }

    protected function makeTitle($column, $ui)
    {
        if (is_string($column)) {

            $default = $column;

        } else {

            $default = null;

        }

        $title = evaluate_key($column, 'title', $default, [$ui]);

        $translated = trans($title);

        if ($translated == $title) {

            $title = humanize($title);

        } else {

            $title = $translated;

        }

        return $title;
    }
}
 