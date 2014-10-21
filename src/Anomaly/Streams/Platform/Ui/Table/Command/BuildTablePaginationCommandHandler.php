<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class BuildTablePaginationCommandHandler
{
    public function handle(BuildTablePaginationCommand $command)
    {
        $ui = $command->getUi();

        $pagination = ['links' => 'LINKS'];

        return compact('pagination');
    }
}
 