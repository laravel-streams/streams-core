<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Guesser;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
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
     * The sections collection.
     *
     * @var SectionCollection
     */
    protected $sections;

    /**
     * Create a new HrefGuesser instance.
     *
     * @param UrlGenerator $url
     * @param Request $request
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

        // Nothing to do if empty.
        if (!$section = $this->sections->active()) {
            return;
        }

        foreach ($buttons as &$button) {

            // Skip if already defined.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            /**
             * If a route has been defined then
             * move that to an HREF closure.
             */
            if (isset($button['route']) && $builder->getFormStream()) {

                $button['attributes']['href'] = function ($entry) use ($button) {

                    /* @var EntryInterface $entry */
                    return $entry->route($button['route']);
                };

                continue;
            }

            switch (array_get($button, 'button')) {

                case 'cancel':
                    $button['attributes']['href'] = $section->getHref();
                    break;

                case 'delete':
                    $button['attributes']['href'] = $section->getHref('delete/' . $entry->getId());
                    break;

                default:

                    // Determine the HREF based on the button type.
                    $type = array_get($button, 'segment', array_get($button, 'button'));

                    if ($type && !str_contains($type, '\\') && !class_exists($type)) {
                        if ($builder instanceof MultipleFormBuilder) {
                            $button['attributes']['href'] = $section->getHref($type . '/{request.route.parameters.id}');
                        } else {
                            $button['attributes']['href'] = $section->getHref($type . '/{entry.id}');
                        }
                    }
                    break;
            }
        }

        $builder->setButtons($buttons);
    }
}
