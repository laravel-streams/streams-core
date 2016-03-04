<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\EnabledGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\PermissionGuesser;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonGuesser
{

    /**
     * The HREF guesser.
     *
     * @var HrefGuesser
     */
    protected $href;

    /**
     * The text guesser.
     *
     * @var TextGuesser
     */
    protected $text;

    /**
     * The enabled guesser.
     *
     * @var EnabledGuesser
     */
    protected $enabled;

    /**
     * The permission guesser.
     *
     * @var PermissionGuesser
     */
    protected $permission;

    /**
     * Create a new ButtonGuesser instance.
     *
     * @param HrefGuesser       $href
     * @param TextGuesser       $text
     * @param EnabledGuesser    $enabled
     * @param PermissionGuesser $permission
     */
    public function __construct(
        HrefGuesser $href,
        TextGuesser $text,
        EnabledGuesser $enabled,
        PermissionGuesser $permission
    ) {
        $this->href       = $href;
        $this->text       = $text;
        $this->enabled    = $enabled;
        $this->permission = $permission;
    }

    /**
     * Guess button properties.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $this->href->guess($builder);
        $this->text->guess($builder);
        $this->permission->guess($builder);
        $this->enabled->guess($builder);
    }
}
