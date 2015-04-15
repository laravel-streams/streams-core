<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

/**
 * Class HrefGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser
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
     * @param SectionCollection $sections
     */
    public function __construct(UrlGenerator $url, Request $request, SectionCollection $sections)
    {
        $this->url      = $url;
        $this->request  = $request;
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

        // Nothing to do if empty.
        if (!$section = $this->sections->active()) {
            return;
        }

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                return;
            }

            // Determine the HREF based on the button type.
            switch (array_get($button, 'button')) {

                case 'edit':
                    $button['attributes']['href'] = $section->getHref('edit/{entry.id}');
                    break;

                case 'delete':
                    $button['attributes']['href'] = $section->getHref('delete/{entry.id}');
                    break;

                case 'view':
                    $button['attributes']['href'] = $section->getHref('view/{entry.id}');
                    break;

                case 'settings':
                    $button['attributes']['href'] = $section->getHref('settings/{entry.id}');
                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
