<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
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
     */
    public function view()
    {
        $route= Request::route();

        $stream = Streams::make($route->getAction('stream'));

        $parameters = $route->parameters();

        if (!$parameters) {
            abort(404);
        }

        $criteria = $stream->entries();

        foreach ($parameters as $parameter => $value) {
            if ($stream->fields->has($parameter) || $stream->isMeta($parameter)) {
                $criteria->where($parameter, $value);
            }
        }

        if (!$entry = $criteria->first()) {
            abort(404);
        }

        /**
         * If the Stream is redirected
         * then redirect here and now.
         */
        if ($stream->redirect) {
            return Response::redirect(
                Str::parse($stream->redirect, compact('entry', 'stream', 'parameters'))
            );
        }

        /**
         * If the Stream has it's own template
         * then go ahead and render that now.
         */
        if ($stream->template) {
            return Response::view(
                Str::parse($stream->template, compact('entry', 'stream', 'parameters')),
                compact('entry', 'stream', 'parameters')
            );
        }

        // Default JSON response.
        return Response::json($entry->toArray());
    }
}
