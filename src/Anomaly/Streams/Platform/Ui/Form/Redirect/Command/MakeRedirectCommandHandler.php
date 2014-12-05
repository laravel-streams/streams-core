<?php namespace Anomaly\Streams\Platform\Ui\Form\Redirect\Command;

use Anomaly\Streams\Platform\Ui\Form\Redirect\RedirectFactory;

class MakeRedirectCommandHandler
{

    protected $factory;

    function __construct(RedirectFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeRedirectCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 