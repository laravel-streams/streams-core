<?php namespace Anomaly\Streams\Platform\Ui\Table\Button\Command;

use Anomaly\Streams\Platform\Ui\Table\Button\ButtonFactory;

class LoadTableButtonsCommandHandler
{
    protected $factory;

    public function __construct(ButtonFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(LoadTableButtonsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $buttons = $table->getButtons();

        foreach ($builder->getButtons() as $parameters) {
            $button = $this->factory->make($parameters);

            $buttons->push($button);
        }
    }
}
