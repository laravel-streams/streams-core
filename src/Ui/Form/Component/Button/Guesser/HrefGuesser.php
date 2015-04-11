<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

/**
 * Class HrefGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser
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
     * The sections collection.
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
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();
        $entry   = $builder->getFormEntry();

        $active = $this->sections->active();

        if (!$active) {
            return;
        }

        foreach ($buttons as &$button) {

            if (isset($button['attributes']['href'])) {
                continue;
            }

            switch (array_get($button, 'button')) {

                case 'cancel':
                    $button['attributes']['href'] = $active->getHref();
                    break;

                case 'delete':
                    $button['attributes']['href'] = $active->getHref('delete/' . $entry->getId());
                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
