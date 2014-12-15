<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

/**
 * Class SetHeaderDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Command
 */
class SetHeaderDataCommandHandler
{

    /**
     * Handle the command.
     *
     * @param SetHeaderDataCommand $command
     */
    public function handle(SetHeaderDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $headers = [];

        foreach ($table->getHeaders() as $header) {
            if ($header instanceof HeaderInterface) {
                $header = $header->viewData();

                $headers[] = $header;
            }
        }

        $table->putData('headers', $headers);
    }
}
