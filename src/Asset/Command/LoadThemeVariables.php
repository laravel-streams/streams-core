<?php namespace Anomaly\Streams\Platform\Asset\Command;

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Asset\Event\ThemeVariablesAreLoading;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;

/**
 * Class LoadThemeVariables
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Command
 */
class LoadThemeVariables implements SelfHandling
{

    /**
     * The theme variables.
     *
     * @var Collection
     */
    protected $variables;

    /**
     * Create a new ThemeVariablesAreLoading instance.
     *
     * @param ThemeCollection $themes
     */
    function __construct(Collection $variables)
    {
        $this->variables = $variables;
    }

    /**
     * Handle the command.
     *
     * @param Dispatcher      $events
     * @param Repository      $config
     * @param ThemeCollection $themes
     */
    public function handle(Dispatcher $events, Repository $config, ThemeCollection $themes)
    {
        $events->fire(new ThemeVariablesAreLoading($this->variables));

        /**
         * If there is a current theme, we've been
         * taken care of already.
         */
        if ($theme = $themes->current()) {
            return;
        }

        $theme = $themes->get($config->get('streams::themes.active.admin'));

        foreach ($config->get($theme->getNamespace('variables'), []) as $key => $value) {
            $this->variables->put($key, $value);
        }
    }
}
