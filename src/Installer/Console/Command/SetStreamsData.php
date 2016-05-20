<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;

/**
 * Class SetStreamsData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console\Command
 */
class SetStreamsData implements SelfHandling
{

    /**
     * The data collection.
     *
     * @var Collection
     */
    protected $data;

    /**
     * Create a new SetStreamsData instance.
     *
     * @param Collection $data
     */
    function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->data->put('APP_ENV', 'local');
        $this->data->put('INSTALLED', 'false');
        $this->data->put('APP_KEY', str_random(32));
    }
}
