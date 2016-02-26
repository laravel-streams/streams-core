<?php namespace Anomaly\Streams\Platform\Support;

use TwigBridge\Bridge;

/**
 * Class Template
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Template
{

    /**
     * The twig instance.
     *
     * @var Bridge
     */
    protected $twig;

    /**
     * Create a new Template instance.
     *
     * @param Bridge $twig
     */
    public function __construct(Bridge $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Render a string template.
     *
     * @param       $template
     * @param array $payload
     * @return string
     * @throws \Exception
     */
    function render($template, array $payload = [])
    {
        $template = $this->twig->createTemplate($template);

        return $template->render($payload);
    }
}
