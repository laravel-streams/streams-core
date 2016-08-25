<?php namespace Anomaly\Streams\Platform\Ui\Command;

/**
 * Class GetElapsedTime
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class GetElapsedTime
{

    /**
     * The request time
     * decimal precision.
     *
     * @var int
     */
    protected $decimals;

    /**
     * Create a new GetElapsedTime instance.
     *
     * @param int $decimals
     */
    public function __construct($decimals = 2)
    {
        $this->decimals = $decimals;
    }

    /**
     * Handle the command.
     *
     * @return string
     */
    public function handle()
    {
        return number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], $this->decimals) . ' s';
    }
}
