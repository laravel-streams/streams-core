<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\LoadForm;
use Anomaly\Streams\Platform\View\ViewTemplate;
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
     * The view template.
     *
     * @var ViewTemplate
     */
    protected $template;

    /**
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new LoadFormHandler instance.
     *
     * @param Container    $container
     * @param ViewTemplate $template
     */
    public function __construct(Container $container, ViewTemplate $template)
    {
        $this->template  = $template;
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

        if ($layout = $form->getOption('layout_view')) {
            $this->template->put('layout', $layout);
        }

        $form->addData('form', $form);
    }
}
