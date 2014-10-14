<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildTableOptionsCommandHandler implements CommandInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();

        $paginate = evaluate($ui->getPaginate(), [$ui]);

        return compact('paginate');
    }
}
 