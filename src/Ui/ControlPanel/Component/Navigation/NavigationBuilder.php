<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class NavigationBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationBuilder
{

    /**
     * The input reader.
     *
     * @var NavigationInput
     */
    protected $input;

    /**
     * The link factory.
     *
     * @var NavigationFactory
     */
    protected $factory;

    /**
     * Create a new NavigationBuilder instance.
     *
     * @param NavigationInput   $input
     * @param NavigationFactory $factory
     */
    public function __construct(NavigationInput $input, NavigationFactory $factory)
    {
        $this->input   = $input;
        $this->factory = $factory;
    }

    /**
     * Build the navigation.
     *
     * @param ControlPanelBuilder $builder
     */
    public function build(ControlPanelBuilder $builder)
    {

        $controlPanel = $builder->getControlPanel();

        $this->input->read($builder);
        foreach ($builder->getNavigation() as $link) {
            if (!empty($link['sections'])) {
                foreach ($link['sections'] as $key => $section) {
                    $tmpLink = $link;
                    if (isset($section['href'])) {
                        $tmpLink['attributes']['href'] = $section['href'];
                    } else {
                        $tmpLink['attributes']['href'] .= "/" . $key;
                    }
                    $tmpLink['title'] = $tmpLink['slug'] . "::section." . $key . ".title";
                    $controlPanel->addNavigationLink($this->factory->make($tmpLink));
                }
            }else{
                $controlPanel->addNavigationLink($this->factory->make($link));
            }
        }
    }
}
