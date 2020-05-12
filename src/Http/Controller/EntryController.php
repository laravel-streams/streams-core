<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Anomaly\Streams\Platform\Entry\Entry;
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
//class EntryController extends AdminController
class EntryController extends PublicController
{

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * Create a new EntryController instance.
     *
     * @param AddonCollection $addons
     */
    public function __construct(AddonCollection $addons)
    {
        //parent::__construct();

        $this->addons = $addons;
    }

    public function render($slug)
    {
        $stream = app('streams::' . request()->route()->getAction('stream'));

        $entry = decorate($stream->repository()->find($slug));

        if (!$entry || !$entry->id) {
            abort(404);
        }

        /**
         * @todo move this as well I am sure.. middleware?
         */
        if ($stream->redirect) {
            return redirect(Str::parse($stream->redirect, compact('entry', 'stream', 'slug')));
        }

        /**
         * @todo move this as well I am sure.. middleware?
         */
        if ($entry->redirect) {
            return redirect(Str::parse($entry->redirect, compact('entry', 'stream', 'slug')));
        }

        /**
         * @todo probably set this in middleware with cascade style access?
         */
        if ($stream->template) {
            return view($stream->template, compact('stream', 'entry'));
        }

        return response()->json($entry->toArray());
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
        // @todo this needs to be resolved.. 
        $stream = StreamManager::get($stream);

        /*
         * Resolve the model and set
         * it on the repository.
         */
        $repository = (new EntryRepository)->setModel($stream->model);

        $entry = $repository->findTrashed($id);

        if (!Gate::allows("{$stream->slug}.update")) {
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

        if (!Gate::allows("{$stream->slug}.view")) {
            abort(403);
        }

        $headers = [
            'Content-Disposition' => 'attachment; filename=' . $stream->slug . '.csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Pragma'              => 'public',
            'Expires'             => '0',
        ];

        $callback = function () use ($repository) {

            $output = fopen('php://output', 'w');

            foreach ($repository->all() as $k => $entry) {

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
