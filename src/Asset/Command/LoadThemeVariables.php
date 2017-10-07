<?php namespace Anomaly\Streams\Platform\Asset\Command;

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Asset\Event\ThemeVariablesHaveLoaded;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Websemantics\Lcss2php\Lcss2php;

/**
 * Class LoadThemeVariables
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadThemeVariables
{

    /**
     * The theme variables.
     *
     * @var Collection
     */
    protected $variables;

    /**
     * The default variables files.
     *
     * @var array
     */
    protected $default = [
        'resources/less/theme/variables.less',
        'resources/scss/theme/_variables.scss',
    ];

    /**
     * Create a new ThemeVariablesHaveLoaded instance.
     *
     * @param ThemeCollection $themes
     */
    public function __construct(Collection $variables)
    {
        $this->variables = $variables;
    }

    /**
     * Handle the command.
     *
     * @param Dispatcher      $events
     * @param Repository      $config
     * @param ThemeCollection $themes
     * @internal param Repository $config
     */
    public function handle(Dispatcher $events, Repository $config, ThemeCollection $themes)
    {
        if (!$theme = $themes->current()) {
            return;
        }

        /**
         * Get all configured variables first.
         * These are law because they're often
         * tied to addon integration of some kind.
         */
        $configured = $config->get($theme->getNamespace('variables'), []);

        /**
         * Look for a list of variables files theme configuration:
         *
         * 'variables' => env('THEME_VARIABLES', ['resources/less/theme/variables.less']),
         *
         * If none exist, use defaults.
         */
        $files = array_map(
            function ($file) use ($theme) {
                return $theme->getPath($file);
            },
            $config->get($theme->getNamespace('config.variables'), $this->default)
        );

        $variables = (new Lcss2php($files))->ignore([\Leafo\ScssPhp\Type::T_MAP, \Leafo\ScssPhp\Type::T_MIXIN]);

        foreach (array_merge($variables->all(), $configured) as $key => $value) {
            $this->variables->put($key, $value);
        }

        $events->fire(new ThemeVariablesHaveLoaded($this->variables));
    }
}
