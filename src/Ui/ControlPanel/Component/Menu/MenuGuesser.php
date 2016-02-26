<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser\PermissionGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class MenuGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuGuesser
{

    /**
     * The text guesser.
     *
     * @var TextGuesser
     */
    protected $text;

    /**
     * The HREF guesser.
     *
     * @var HrefGuesser
     */
    protected $href;

    /**
     * The permission guesser.
     *
     * @var PermissionGuesser
     */
    protected $permission;

    /**
     * Create a new MenuGuesser instance.
     *
     * @param TextGuesser       $text
     * @param HrefGuesser       $href
     * @param PermissionGuesser $permission
     */
    function __construct(TextGuesser $text, HrefGuesser $href, PermissionGuesser $permission)
    {
        $this->text       = $text;
        $this->href       = $href;
        $this->permission = $permission;
    }

    /**
     * Guess menu properties.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $this->text->guess($builder);
        $this->href->guess($builder);
        $this->permission->guess($builder);
    }
}
