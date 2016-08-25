<?php namespace Anomaly\Streams\Platform\Ui\Command;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GetMemoryUsage
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Command
 */
class GetMemoryUsage implements SelfHandling
{

    /**
     * The request time
     * decimal precision.
     *
     * @var int
     */
    protected $precision;

    /**
     * Create a new GetMemoryUsage instance.
     *
     * @param int $precision
     */
    public function __construct($precision = 1)
    {
        $this->precision = $precision;
    }

    /**
     * Handle the command.
     *
     * @return string
     */
    public function handle()
    {
        $size = memory_get_usage(true);

        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return round($size / pow(1024, ($i = floor(log($size, 1024)))), $this->precision) . ' ' . $unit[$i];
    }
}
