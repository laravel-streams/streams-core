<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class MenuBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuBuilder
{

    /**
     * The menu input.
     *
     * @var MenuInput
     */
    protected $input;

    /**
     * The menu factory.
     *
     * @var MenuFactory
     */
    protected $factory;

    /**
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new MenuBuilder instance.
     *
     * @param MenuInput   $input
     * @param MenuFactory $factory
     * @param Authorizer  $authorizer
     */
    function __construct(MenuInput $input, MenuFactory $factory, Authorizer $authorizer)
    {
        $this->input      = $input;
        $this->factory    = $factory;
        $this->authorizer = $authorizer;
    }

    /**
     * Build the menus and push them to the control_panel.
     *
     * @param ControlPanelBuilder $builder
     */
    public function build(ControlPanelBuilder $builder)
    {
        $controlPanel = $builder->getControlPanel();
        $menus        = $controlPanel->getMenu();

        $this->input->read($builder);

        foreach ($builder->getMenu() as $slug => $menu) {

            if (!$this->authorizer->authorize($menu['permission'])) {
                continue;
            }

            $menus->put($slug, $this->factory->make($menu));
        }
    }
}
