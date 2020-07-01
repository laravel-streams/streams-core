<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Stream\StreamManager;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\Streams\Platform\Support\Facades\Streams;

/**
 * Class EntryController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryController extends Controller
{

    /**
     * Return a Stream entry's view.
     *
     * @param string $slug
     */
    public function render($slug)
    {
        $stream = Streams::make(Request::route()->getAction('stream'));

        if (!$entry = $stream->find($slug)) {
            abort(404);
        }

        if ($stream->redirect) {
            return Response::redirect(
                Str::parse($stream->redirect, compact('entry', 'stream', 'slug'))
            );
        }

        if ($stream->template) {
            return Response::view(
                Str::parse($stream->template, compact('entry', 'stream', 'slug')),
                compact('entry', 'stream', 'slug')
            );
        }

        return Response::json($entry->toArray());
    }
}
