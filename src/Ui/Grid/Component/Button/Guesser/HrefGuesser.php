<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Component\Button\Guesser;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

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
     * The control panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new HrefGuesser instance.
     *
     * @param UrlGenerator $url
     * @param Request $request
     */
    public function __construct(UrlGenerator $url, Request $request, ControlPanelBuilder $builder)
    {
        $this->url     = $url;
        $this->builder = $builder;
        $this->request = $request;
    }

    /**
     * Guess the HREF for a button.
     *
     * @param GridBuilder $builder
     */
    public function guess(GridBuilder $builder)
    {
        $buttons = $builder->getButtons();

        // Nothing to do if empty.
        if (!$section = $this->builder->controlPanel->sections->active()) {
            return;
        }

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            /**
             * If a route has been defined then
             * move that to an HREF closure.
             */
            if (isset($button['route']) && $builder->getGridStream()) {

                $button['attributes']['href'] = function ($entry) use ($button) {

                    /* @var EntryInterface $entry */
                    return $entry->route($button['route']);
                };

                continue;
            }

            // Determine the HREF based on the button type.
            if ($type = array_get($button, 'segment', array_get($button, 'button'))) {
                $button['attributes']['href'] = $section->getHref($type . '/{entry.id}');
            }
        }

        $builder->setButtons($buttons);
    }
}
