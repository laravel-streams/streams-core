<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

class HandleFormAuthorizationCommandHandler
{

    public function handle(HandleFormAuthorizationCommand $command)
    {
        $builder = $command->getBuilder();
    }
}
 