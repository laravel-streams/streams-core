<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

/**
 * Class HrefGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The section collection.
     *
     * @var SectionCollection
     */
    protected $sections;

    /**
     * Create a new HrefGuesser instance.
     *
     * @param UrlGenerator      $url
     * @param Request           $request
     * @param ModuleCollection  $modules
     * @param SectionCollection $sections
     */
    public function __construct(
        UrlGenerator $url,
        Request $request,
        ModuleCollection $modules,
        SectionCollection $sections
    ) {
        $this->url      = $url;
        $this->request  = $request;
        $this->modules  = $modules;
        $this->sections = $sections;
    }

    /**
     * Guess the HREF for a button.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $buttons = $builder->getButtons();

        if (!$section = $this->sections->active()) {
            return;
        }

        if (!$module = $this->modules->active()) {
            return;
        }

        $stream = $builder->getTableStream();

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            switch (array_get($button, 'button')) {

                case 'restore':

                    $button['attributes']['href'] = $this->url->to(
                        'entry/handle/restore/' . $module->getNamespace() . '/' . $stream->getNamespace(
                        ) . '/' . $stream->getSlug() . '/{entry.id}'
                    );

                    break;

                default:

                    // Determine the HREF based on the button type.
                    $type = array_get($button, 'segment', array_get($button, 'button'));

                    if ($type && !str_contains($type, '\\') && !class_exists($type)) {
                        $button['attributes']['href'] = $section->getHref($type . '/{entry.id}');
                    }

                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
