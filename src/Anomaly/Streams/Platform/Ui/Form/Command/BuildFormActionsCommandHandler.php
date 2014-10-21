<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

class BuildFormActionsCommandHandler
{
    public function handle(BuildFormActionsCommand $command)
    {
        $ui = $command->getUi();

        $actions = [];

        foreach ($ui->getActions() as $action) {

            $title = $this->makeTitle($action, $ui);

            $actions[] = compact('title');

        }

        return $actions;
    }

    protected function makeTitle($action, $ui)
    {
        return trans(evaluate_key($action, 'title', null, [$ui]));
    }
}
 