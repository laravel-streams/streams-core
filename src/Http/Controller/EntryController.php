<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Support\Facades\Redirect;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Stream\StreamManager;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Entry\EntryRepository;

/**
 * Class EntryController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * The authorizer service.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new EntryController instance.
     *
     * @param AddonCollection $addons
     * @param Authorizer $authorizer
     */
    public function __construct(AddonCollection $addons, Authorizer $authorizer)
    {
        parent::__construct();

        $this->addons     = $addons;
        $this->authorizer = $authorizer;
    }

    /**
     * Restore an entry.
     *
     * @param $addon
     * @param $namespace
     * @param $stream
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($addon, $stream, $id)
    {
        /* @var StreamInterface $stream */
        $stream = StreamManager::get($stream);

        /*
         * Resolve the model and set
         * it on the repository.
         */
        $repository = (new EntryRepository)->setModel($stream->model);

        $entry = $repository->findTrashed($id);

        if (!$this->authorizer->authorize("{$addon}::{$stream->getSlug()}.write")) {
            abort(403);
        }

        if (!$entry->isRestorable()) {

            messages('error', 'streams::message.restore_failed');

            return back();
        }

        $repository->restore($entry);

        messages('success', 'streams::message.restore_success');

        return Redirect::back();
    }

    /**
     * Export all entries.
     *
     * @param $addon
     * @param $stream
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export($addon, $stream)
    {
        /* @var StreamInterface $stream */
        $stream = StreamManager::get($stream);

        /*
         * Resolve the model and set
         * it on the repository.
         */
        $repository = (new EntryRepository)->setModel($stream->model);

        if (!$this->authorizer->authorize($addon->getNamespace($stream->getSlug() . '.read'))) {
            abort(403);
        }

        $headers = [
            'Content-Disposition' => 'attachment; filename=' . $stream->getSlug() . '.csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Pragma'              => 'public',
            'Expires'             => '0',
        ];

        $callback = function () use ($repository) {
            
            $output = fopen('php://output', 'w');

            foreach ($repository->allWithoutRelations() as $k => $entry) {
                
                if ($k == 0) {
                    fputcsv($output, array_keys($entry->toArray()));
                }

                fputcsv($output, $entry->toArray());
            }

            fclose($output);
        };

        return $this->response->stream($callback, 200, $headers);
    }
}
