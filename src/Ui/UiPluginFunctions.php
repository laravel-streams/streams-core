<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;
use Illuminate\Container\Container;

/**
 * Class UiPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class UiPluginFunctions
{

    /**
     * The icon registry.
     *
     * @var IconRegistry
     */
    protected $icons;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new UiPluginFunctions instance.
     *
     * @param IconRegistry $icons
     * @param Hydrator     $hydrator
     * @param Container    $container
     */
    public function __construct(IconRegistry $icons, Hydrator $hydrator, Container $container)
    {
        $this->icons     = $icons;
        $this->hydrator  = $hydrator;
        $this->container = $container;
    }

    /**
     * Return icon HTML.
     *
     * @param      $type
     * @param null $class
     * @return string
     */
    public function icon($type, $class = null)
    {
        return '<i class="' . $this->icons->get($type) . ' ' . $class . '"></i>';
    }

    /**
     * Render buttons.
     *
     * @param $buttons
     * @return \Illuminate\View\View
     */
    public function buttons($buttons)
    {
        return view('streams::buttons/buttons', compact('buttons'));
    }

    /**
     * Render JavaScript constants.
     *
     * @return \Illuminate\View\View
     */
    public function constants()
    {
        return view('streams::partials/constants');
    }

    /**
     * Handle form control.
     *
     * @param array $parameters
     * @return Form\FormPresenter
     */
    public function form(array $parameters = [])
    {
        if (!$builder = array_pull($parameters, 'builder')) {
            $builder = FormBuilder::class;
        }

        /* @var FormBuilder $builder */
        $builder = $this->container->make($builder);

        $this->hydrator->hydrate($builder, $parameters);

        $builder->make();

        return $builder->getFormPresenter();
    }
}
