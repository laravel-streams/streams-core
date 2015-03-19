<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class TablePlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TablePlugin extends Plugin
{

    /**
     * Table plugin functions.
     *
     * @var TablePluginFunctions
     */
    protected $functions;

    /**
     * Create a new TablePlugin instance.
     *
     * @param TablePluginFunctions $functions
     */
    public function __construct(TablePluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Return table plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('table_views', [$this->functions, 'views']),
            new \Twig_SimpleFunction('table_filters', [$this->functions, 'filters']),
            new \Twig_SimpleFunction('table_header', [$this->functions, 'header']),
            new \Twig_SimpleFunction('table_body', [$this->functions, 'body']),
            new \Twig_SimpleFunction('table_footer', [$this->functions, 'footer']),
            new \Twig_SimpleFunction('table_column', [$this->functions, 'column']),
        ];
    }
}
