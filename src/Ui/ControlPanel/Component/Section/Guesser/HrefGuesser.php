<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Illuminate\Routing\UrlGenerator;

/**
 * Class HrefGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser
 */
class HrefGuesser
{

    /**
     * The URL generator.
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new HrefGuesser instance.
     *
     * @param ModuleCollection $modules
     * @param UrlGenerator     $url
     */
    public function __construct(ModuleCollection $modules, UrlGenerator $url)
    {
        $this->url     = $url;
        $this->modules = $modules;
    }

    /**
     * Guess the sections HREF attribute.
     *
     * @param array $section
     */
    public function guess(array &$section)
    {
        // If HREF is set then skip it.
        if (isset($section['attributes']['href'])) {
            return;
        }

        $module = $this->modules->active();

        $href = $this->url->to('admin/' . $module->getSlug());

        if ($module->getSlug() !== $section['slug']) {
            $href .= '/' . $section['slug'];
        }

        $section['attributes']['href'] = $href;
    }
}
