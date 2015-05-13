<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser\PermissionGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SectionGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section
 */
class SectionGuesser
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
     * Create a new SectionGuesser instance.
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
     * Guess section properties.
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
