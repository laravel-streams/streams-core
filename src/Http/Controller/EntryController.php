<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Support\Authorizer;

/**
 * Class EntryController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Http\Controller
 */
class EntryController extends AdminController
{

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * The stream repository.
     *
     * @var StreamRepositoryInterface
     */
    protected $streams;

    /**
     * The authorizer service.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * The entry repository.
     *
     * @var EntryRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new EntryController instance.
     *
     * @param AddonCollection           $addons
     * @param Authorizer                $authorizer
     * @param StreamRepositoryInterface $streams
     * @param EntryRepositoryInterface  $repository
     */
    public function __construct(
        AddonCollection $addons,
        Authorizer $authorizer,
        StreamRepositoryInterface $streams,
        EntryRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->addons     = $addons;
        $this->streams    = $streams;
        $this->authorizer = $authorizer;
        $this->repository = $repository;
    }

    /**
     * Delete an entry.
     *
     * @param $addon
     * @param $namespace
     * @param $stream
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($addon, $namespace, $stream, $id)
    {
        $addon = $this->addons->get($addon);

        /* @var StreamInterface $stream */
        $stream = $this->streams->findBySlugAndNamespace($stream, $namespace);

        /**
         * Resolve the model and set
         * it on the repository.
         */
        $this->repository->setModel($this->container->make($stream->getEntryModelName()));

        $entry = $this->repository->findTrashed($id);

        if (!$this->authorizer->authorize($addon->getNamespace($stream->getSlug() . '.restore'))) {
            abort(403);
        }

        if (!$entry->isRestorable()) {

            $this->messages->error('streams::message.restore_failed');

            return $this->redirect->back();
        }

        $this->repository->restore($entry);

        $this->messages->success('streams::message.restore_success');

        return $this->redirect->back();
    }
}
