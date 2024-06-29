<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

use Anomaly\Streams\Platform\Addon\Addon;
use Twig\Environment;
use Twig\Extension;
use Twig\NodeVisitor\NodeVisitorInterface;

/**
 * Class Plugin
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Plugin extends Addon implements Extension\ExtensionInterface
{

    /**
     * Get plugin name for Twig.
     *
     * @return string
     */
    public function getName()
    {
        return isset($this->slug) ? parent::getName() : get_class($this);
    }

    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
     * @param Environment $environment The current Twig\Environment instance
     */
    public function initRuntime(Environment $environment)
    {
    }

    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return array An array of Twig_TokenParserInterface or Twig_TokenParserBrokerInterface instances
     */
    public function getTokenParsers()
    {
        return [];
    }

    /**
     * Returns the node visitor instances to add to the existing list.
     *
     * @return NodeVisitorInterface[] An array of NodeVisitorInterface instances
     */
    public function getNodeVisitors()
    {
        return [];
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return [];
    }

    /**
     * Returns a list of tests to add to the existing list.
     *
     * @return array An array of tests
     */
    public function getTests()
    {
        return [];
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [];
    }

    /**
     * Returns a list of operators to add to the existing list.
     *
     * @return array An array of operators
     */
    public function getOperators()
    {
        return [];
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [];
    }
}
