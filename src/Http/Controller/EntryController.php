<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
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
        $criteria = $stream->entries();
        
        if (!$parameters) {
            abort(404);
        }

        // @todo use keyname from stream at least
        $identifier = Arr::get($parameters, 'id', Arr::get($parameters, 'handle'));
        
        if ($identifier && !$entry = $criteria->find($identifier)) {
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
                Str::parse($stream->template, compact('entry', 'stream', 'params')),
                compact('entry', 'stream', 'params')
            );
        }

        // Default JSON response.
        return Response::json($entry->toArray());
    }
}
