<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Eloquent\Collection;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\Streams\Platform\Model\EloquentRepository;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;

/**
 * Class StreamRepository
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamRepository extends EntryRepository implements StreamRepositoryInterface
{

    /**
     * The stream model.
     *
     * @var
     */
    protected $model;

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new StreamRepository instance.
     *
     * @param StreamModel $model
     */
    public function __construct(StreamModel $model)
    {
        $this->model = $model;

        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Create a new Stream.
     *
     * @param  array $attributes
     * @return StreamInterface
     */
    public function create(array $attributes = [])
    {
        $attributes['config'] = Arr::get($attributes, 'config', []);
        $attributes['slug']   = Str::slug(Arr::get($attributes, 'slug'), '_');

        return $this->model->create($attributes);
    }

    /**
     * Find a stream by it's namespace and slug.
     *
     * @param  $slug
     * @param  $namespace
     * @return null|StreamInterface
     */
    public function findBySlugAndNamespace($slug, $namespace)
    {
        return $this->model->where('slug', $slug)->where('namespace', $namespace)->first();
    }

    /**
     * Find all streams by their searchable flag.
     *
     * @param $searchable
     * @return StreamCollection
     */
    public function findAllBySearchable($searchable)
    {
        return $this->model->where('searchable', $searchable)->get();
    }

    /**
     * Find all streams in a namespace.
     *
     * @param  $namespace
     * @return null|Collection
     */
    public function findAllByNamespace($namespace)
    {
        return $this->model->where('namespace', $namespace)->get();
    }

    /**
     * Return streams that are/not hidden.
     *
     * @param $hidden
     * @return StreamCollection
     */
    public function hidden($hidden = true)
    {
        return $this->model->where('hidden', $hidden)->get();
    }

    /**
     * Return only visible streams.
     *
     * @return StreamCollection
     */
    public function visible()
    {
        return $this->hidden(false);
    }

    /**
     * Destroy a namespace.
     *
     * @param $namespace
     */
    public function destroy($namespace)
    {
        foreach ($this->findAllByNamespace($namespace) as $stream) {
            $this->delete($stream);
        }

        $this->cleanup();
    }

    /**
     * Clean up abandoned streams.
     */
    public function cleanup()
    {
        /* @var StreamInterface $stream */
        foreach ($this->model->all() as $stream) {
            if (!$this->schema->hasTable($stream->getEntryTableName())) {
                $this->delete($stream);
            }
        }
    }
}
