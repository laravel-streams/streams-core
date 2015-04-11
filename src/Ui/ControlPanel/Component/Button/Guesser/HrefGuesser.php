<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

/**
 * Class HrefGuesser
 *
 * @link          http://anomaly.is/streams-Platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser
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
     * Create a new HrefGuesser instance.
     *
     * @param UrlGenerator $url
     * @param Request      $request
     */
    public function __construct(UrlGenerator $url, Request $request)
    {
        $this->url     = $url;
        $this->request = $request;
    }

    /**
     * Guess the HREF for a button.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $buttons  = $builder->getButtons();
        $sections = $builder->getControlPanelSections();

        $active = $sections->active();

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            // Determine the HREF based on the button type.
            switch (array_get($button, 'button')) {

                case 'new':
                case 'create':
                    $button['attributes']['href'] = $active->getHref('create');
                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
