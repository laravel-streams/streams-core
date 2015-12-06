<?php namespace Anomaly\Streams\Platform\Ui\Icon\Command;

use Anomaly\Streams\Platform\Ui\Icon\Icon;
use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GetIcon
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Icon\Command
 */
class GetIcon implements SelfHandling
{

    /**
     * The icon type.
     *
     * @var string
     */
    protected $type;

    /**
     * The icon class.
     *
     * @var string
     */
    protected $class;

    /**
     * Create a new GetIcon instance.
     *
     * @param $type
     */
    public function __construct($type, $class)
    {
        $this->type  = $type;
        $this->class = $class;
    }

    /**
     * Handle the command.
     *
     * @param IconRegistry $registry
     * @return string
     */
    public function handle(IconRegistry $registry)
    {
        return (new Icon())->setType($registry->get($this->type))->setClass($this->class);
    }
}
