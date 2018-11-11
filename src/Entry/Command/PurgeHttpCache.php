<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Http\HttpCache;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Query\Builder;

/**
 * Class PurgeHttpCache
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PurgeHttpCache
{

    /**
     * The entry object.
     *
     * @var EntryInterface
     */
    protected $entry;

    /**
     * Create a new PurgeHttpCache instance.
     *
     * @param EloquentModel $entry
     */
    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Handle the command.
     *
     * @param HttpCache $cache
     */
    public function handle(HttpCache $cache, Repository $config)
    {
        if (!$config->get('streams::httpcache.enabled')) {
            return;
        }

        $cache->purge(parse_url($this->entry->route('view'), PHP_URL_PATH));
        $cache->purge(parse_url($this->entry->route('index'), PHP_URL_PATH));
        $cache->purge(parse_url($this->entry->route('preview'), PHP_URL_PATH));
    }

}
