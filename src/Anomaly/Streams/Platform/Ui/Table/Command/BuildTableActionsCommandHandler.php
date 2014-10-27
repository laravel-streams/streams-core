<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class BuildTableActionsCommandHandler
{
    public function handle(BuildTableActionsCommand $command)
    {
        $ui = $command->getUi();

        $actions = [];

        foreach ($ui->getActions() as $action) {

            $text  = $this->makeText($action, $ui);
            $class = $this->makeClass($action, $ui);

            $actions[] = compact('text', 'class');

        }

        return $actions;
    }

    protected function makeText($action, $ui)
    {
        return trans(evaluate_key($action, 'text', null, [$ui]));
    }

    protected function makeClass($action, $ui)
    {
        $class = evaluate_key($action, 'class', 'btn btn-sm btn-default', [$ui]);

        return $class;
    }
}
 