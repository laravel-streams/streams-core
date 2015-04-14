<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LoadForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class LoadForm implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new HandleForm instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Container            $container
     * @param ViewTemplate         $template
     * @param BreadcrumbCollection $breadcrumbs
     */
    public function handle(Container $container, ViewTemplate $template, BreadcrumbCollection $breadcrumbs)
    {
        $form = $this->builder->getForm();

        if ($handler = $form->getOption('data')) {
            $container->call($handler, compact('form'));
        }

        if ($layout = $form->getOption('layout_view')) {
            $template->put('layout', $layout);
        }

        if ($title = $form->getOption('title')) {
            $template->put('title', $title);
        }

        $form->addData('form', $form);

        $breadcrumbs->put($form->getOption('breadcrumb', 'streams::form.mode.' . $form->getMode()), '#');
    }
}
