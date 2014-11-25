<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Presets;

/**
 * Class FormPresets
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormPresets extends Presets
{

    /**
     * Section presets.
     *
     * @var array
     */
    protected $sections = [
        'default' => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection',
        ],
        'tabbed'  => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Form\Section\TabbedFormSection',
        ],
    ];

    /**
     * Set redirect presets.
     *
     * @param array $action
     * @return null
     */
    public function setActionPresets(array $action)
    {
        $action = parent::setButtonPresets($action);

        if (!array_key_exists('response', $action)) {

            $action['response'] = $this->guessActionResponse($action['slug']);
        }

        return $action;
    }

    /**
     * Set button presets.
     *
     * @param $button
     * @return null
     */
    public function setButtonPresets(array $button)
    {
        $button = parent::setButtonPresets($button);

        if (!array_key_exists('href', $button)) {

            $button['href'] = $this->guessButtonHref($button['slug']);
        }

        return $button;
    }

    /**
     * Set section presets.
     *
     * @param array $section
     * @return null
     */
    public function setSectionPresets(array $section)
    {
        if (!isset($section['type'])) {
            $section['type'] = 'default';
        }

        if (isset($this->sections[$section['type']]) and $presets = $this->sections[$section['type']]) {

            return array_merge($presets, $section);
        }

        if (!isset($section['handler'])) {

            $section['handler'] = 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection';
        }

        return $section;
    }

    /**
     * Suggest best practices for URLs.
     *
     * URLs should be like: admin/module{/stream}/action/id
     * {/stream} is optional if the module slug == stream slug
     * like admin/users (would not be admin/users/users)
     *
     * @param $slug
     * @return string
     */
    protected function guessActionResponse($slug)
    {
        switch ($slug) {

            // Change the last two segments.
            case 'save':
                $segments = explode('/', app('request')->path());
                $offset   = is_numeric(end($segments)) ? 2 : 1;

                return url(implode('/', array_slice($segments, 0, count($segments) - $offset)));
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Suggest best practices for URLs.
     *
     * URLs should be like: admin/module{/stream}/action/id
     * {/stream} is optional if the module slug == stream slug
     * like admin/users (would not be admin/users/users)
     *
     * @param $slug
     * @return string
     */
    protected function guessButtonHref($slug)
    {
        switch ($slug) {

            // Change the last two segments.
            case 'cancel':
                $segments = explode('/', app('request')->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)));
                break;

            // Change the last two segments
            case 'view':
                $segments = explode('/', app('request')->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/show/' . end($segments));
                break;

            // Change the last two segments
            case 'delete':
                $segments = explode('/', app('request')->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/delete/' . end($segments));
                break;

            default:
                return null;
                break;
        }
    }
}
 