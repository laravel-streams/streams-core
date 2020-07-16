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
        $stream = Streams::make(Request::route()->getAction('stream'));
        $criteria = $stream->entries();
        $params = Request::route()->parameters();


        if (count($params) == 0) {
            abort(404);
        }

        $id = array_pop($params);
        foreach ($params as $field => $param) {
            $criteria->where($field, $param);
        }

        if (!$entry = $stream->entries()->where('year', '2017')->find($id)) {
            abort(404);
        }

        if ($stream->redirect) {
            return Response::redirect(
                Str::parse($stream->redirect, compact('entry', 'stream', 'params'))
            );
        }

        if ($stream->template) {
            return Response::view(
                Str::parse($stream->template, compact('entry', 'stream', 'params')),
                compact('entry', 'stream', 'params')
            );
        }

        return Response::json($entry->toArray());
    }
}
