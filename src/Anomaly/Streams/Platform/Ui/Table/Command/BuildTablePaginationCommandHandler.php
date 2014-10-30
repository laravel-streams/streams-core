<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class BuildTablePaginationCommandHandler
 *
 * This class builds the pagination data for the view
 * based on the paginator that was set on the table UI
 * class earlier. Most likely from the Repository during get().
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTablePaginationCommandHandler
{

    /**
     * Handle the command.
     *
     * @param $command
     * @return array|null
     */
    public function handle($command)
    {
        $ui = $command->getUi();

        $paginator = $ui->getPaginator();

        if ($paginator) {

            $data = $paginator->toArray();

            $data['links'] = $paginator->appends($_GET)->render();

            return $data;

        }

        return null;
    }
}
 