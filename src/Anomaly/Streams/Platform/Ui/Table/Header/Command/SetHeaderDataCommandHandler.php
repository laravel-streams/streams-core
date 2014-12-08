<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

class SetHeaderDataCommandHandler
{

    public function handle(SetHeaderDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $headers = [];

        foreach ($table->getHeaders() as $header) {

            if ($header instanceof HeaderInterface) {

                $headers[] = $header->viewData();
            }
        }

        $table->putData('headers', $headers);
    }
}
 