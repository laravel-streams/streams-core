<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\LoadForm;
use Illuminate\Container\Container;

/**
 * Class LoadFormHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class LoadFormHandler
{

    /**
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new LoadTableHandler instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Handle the command.
     *
     * @param LoadForm $command
     */
    public function handle(LoadForm $command)
    {
        $form = $command->getForm();

        if ($form->getStream()) {
            $form->setOption('translatable', $form->getStream()->isTranslatable());
        }

        if ($handler = $form->getOption('data')) {
            $this->container->call($handler, compact('form'));
        }

        $form->addData('form', $form);
    }
}
