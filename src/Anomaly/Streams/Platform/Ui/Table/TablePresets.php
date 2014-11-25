<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Presets;

/**
 * Class TablePresets
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TablePresets extends Presets
{

    /**
     * Preset action configurations.
     *
     * @var array
     */
    protected $actions = [
        'success'    => [
            'class' => 'btn btn-sm btn-success',
        ],
        'info'       => [
            'class' => 'btn btn-sm btn-info',
        ],
        'warning'    => [
            'class' => 'btn btn-sm btn-warning',
        ],
        'danger'     => [
            'class' => 'btn btn-sm btn-danger',
        ],
        'preset'     => [
            'class' => 'btn btn-sm btn-preset',
        ],
        'view'       => [
            'title' => 'admin.button.view',
            'class' => 'btn btn-sm btn-info',
        ],
        'options'    => [
            'title' => 'admin.button.options',
            'class' => 'btn btn-sm btn-preset',
        ],
        'edit'       => [
            'title' => 'admin.button.edit',
            'class' => 'btn btn-sm btn-warning',
        ],
        'delete'     => [
            'title' => 'admin.button.delete',
            'class' => 'btn btn-sm btn-danger',
        ],
        'confirm'    => [
            'class'        => 'btn btn-sm btn-danger',
            'data-confirm' => 'confirm.delete',
        ],
        'trash-icon' => [
            'class' => 'btn btn-sm btn-link',
            'title' => '<i class="fa fa-trash"></i>',
        ],
    ];

    /**
     * Preset view configurations.
     *
     * @var array
     */
    protected $views = [
        'all' => [
            'title'   => 'misc.all',
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\View\All@handle',
        ]
    ];

    /**
     * Set preset data for a button. Guess it's URL
     * afterward based on the slug.
     *
     * @param array $button
     */
    public function setButtonPresets(array $button)
    {
        $button = parent::setButtonPresets($button);

        if (!isset($button['href'])) {

            $button['href'] = $this->guessButtonHref($button['slug']);
        }

        return $button;
    }


    /**
     * Set preset data for an action.
     *
     * @param array $action
     * @return array
     */
    public function setActionPresets(array $action)
    {
        $action = parent::setButtonPresets($action);

        return $action;
    }

    /**
     * Set preset data for a view.
     *
     * @param array $view
     * @return array
     */
    public function setViewPresets(array $view)
    {
        if (isset($this->views[$view['slug']]) and $presets = $this->views[$view['slug']]) {

            return array_merge($presets, $view);
        }

        return $view;
    }

    /**
     * Try and guess the HREF for preset stuff to propel
     * best practices and standards. This will be overridden
     * by any value that's passed in.
     *
     * @param $slug
     */
    protected function guessButtonHref($slug)
    {
        $path = app('router')->getCurrentRoute()->getPath();

        switch ($slug) {

            // Suggest best practices for view URLs
            case 'view':
                return function (EntryInterface $entry) use ($path) {
                    return $path .= '/show/' . $entry->getId();
                };
                break;

            // Suggest best practices for edit URLs
            case 'edit':
                return function (EntryInterface $entry) use ($path) {
                    return $path .= '/edit/' . $entry->getId();
                };
                break;

            // Suggest best practices for delete URLs
            case 'delete':
                return function (EntryInterface $entry) use ($path) {
                    return $path .= '/delete/' . $entry->getId();
                };
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Add a button preset.
     *
     * @param $slug
     * @param $button
     */
    public function addButton($slug, $button)
    {
        $this->buttons[$slug] = $button;
    }

    /**
     * Add an action preset.
     *
     * @param $slug
     * @param $action
     */
    public function addAction($slug, $action)
    {
        $this->actions[$slug] = $action;
    }

    /**
     * Add a view preset.
     *
     * @param $slug
     * @param $view
     */
    public function addView($slug, $view)
    {
        $this->views[$slug] = $view;
    }
}
 