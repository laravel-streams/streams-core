<?php namespace Anomaly\Streams\Platform\Console;

use Symfony\Component\Console\Input\InputOption;

/**
 * Class Application
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Console
 */
class Application extends \Illuminate\Console\Application
{

    /**
     * Get the default definition.
     *
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();

        $definition->addOption($this->getApplicationReferenceOption());

        return $definition;
    }

    /**
     * Get the global environment option for the definition.
     *
     * @return \Symfony\Component\Console\Input\InputOption
     */
    protected function getApplicationReferenceOption()
    {
        $message = 'The application the command should run under.';

        return new InputOption('--app', null, InputOption::VALUE_OPTIONAL, $message);
    }
}
