<?php namespace Anomaly\Streams\Platform\View\Event;

use Anomaly\Streams\Platform\View\ViewTemplate;

/**
 * Class TemplateDataIsLoading
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Event
 */
class TemplateDataIsLoading
{

    /**
     * Create a new TemplateDataIsLoading instance.
     *
     * @param ViewTemplate $template
     */
    public function __construct(ViewTemplate $template)
    {
        $this->template = $template;
    }

    /**
     * Get the template.
     *
     * @return ViewTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
