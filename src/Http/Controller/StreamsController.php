<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;

/**
 * Class StreamsController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamsController extends Controller
{

    use FiresCallbacks;

    /**
     * Handle the request.
     * 
     * @return Response
     */
    public function handle()
    {
        $data = collect();

        $workflow = new Workflow([
            'resolve_stream' => [$this, 'resolveStream'],
            'resolve_entry' => [$this, 'resolveEntry'],
            'resolve_view' => [$this, 'resolveView'],
            'resolve_redirect' => [$this, 'resolveRedirect'],
            'resolve_response' => [$this, 'resolveResponse'],
        ]);

        $this->fire('handling', [
            'data' => $data,
            'workflow' => $workflow
        ]);

        $workflow
            ->passThrough($this)
            ->process(['data' => $data]);
            
        $this->fire('responding', ['data' => $data]);

        if ($response = $data->get('response')) {
            return $response;
        }

        abort(404);
    }

    /**
     * Resolve the stream.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveStream(Collection $data)
    {
        $action = Request::route()->action;

        if (isset($action['stream'])) {

            $data->put('stream', Streams::make($action['stream']));

            return;
        }

        /**
         * Try and use the route parameters
         * to resolve the stream otherwise.
         */
        $parameters = Request::route()->parameters;

        if (isset($parameters['stream'])) {

            $data->put('stream', Streams::make($parameters['stream']));

            return;
        }
    }

    /**
     * Resolve the entry.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveEntry(Collection $data)
    {

        $action = Request::route()->action;

        /**
         * We at least need a stream to
         * continue figuring out a view.
         */
        if (!$stream = $data->get('stream')) {
            return;
        }
        
        /**
         * If the entry is explicitly set then
         * find it and get on with the show.
         */
        if (isset($action['entry'])) {

            $data->put('entry', $stream->repository()->find($action['entry']));

            return;
        }
        
        /**
         * Try and use the route parameters
         * to resolve an entry otherwise.
         */
        $parameters = Request::route()->parameters;

        if (isset($parameters['id'])) {

            $data->put('entry', $stream->repository()->find($parameters['id']));

            return;
        }

        if (isset($parameters['handle'])) {

            $data->put('entry', $stream->repository()->find($parameters['handle']));

            return;
        }

        /**
         * Try and loop over parameters
         * to query a result from them.
         */
        $query = $stream->entries();

        foreach ($parameters as $key => $value) {
            if (Str::startsWith($key, 'entry__')) {
                $query->where(str_replace('entry__', '', $key), $value);
            }
        }

        $results = $query->limit(1)->get();

        if ($results->isNotEmpty()) {
            $data->put('entry', $results->first());
        }
    }

    /**
     * Resolve the view.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveView(Collection $data)
    {

        $action = Request::route()->action;

        /**
         * Check if the entry is 
         * overriding the view.
         */
        if (
            ($entry = $data->get('entry'))
            && $view = $entry->getPrototypeAttribute('streams__view')
        ) {

            $data->put('view', $view);

            return;
        }

        /**
         * If the view is set
         * then use it as is.
         */
        if (isset($action['view'])) {

            $data->put('view', $action['view']);

            return;
        }

        /**
         * We at least need a stream to
         * continue figuring out a view.
         */
        if (!$stream = $data->get('stream')) {
            return;
        }

        /**
         * Try to use the route name to
         * guess the view template to use.
         * 
         * @todo Would be nice to configure this behavior to /stream/action.blade.php for example
         */
        $name = Arr::get($action, 'as');

        if ($name && Str::is('streams::*.index', $name) && View::exists($view = $stream->handle)) {

            $data->put('view', $view);

            return;
        }

        if ($name && Str::is('streams::*.view', $name) && View::exists($view = Str::singular($stream->handle))) {

            $data->put('view', $view);

            return;
        }

        /**
         * Try falling back to the stream template.
         */
        if ($stream->template) {
            $data->put('view', $stream->template);
        }
    }

    /**
     * Resolve the redirect.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveRedirect(Collection $data)
    {

        $action = Request::route()->action;

        /**
         * If a redirect is set
         * then use it as is.
         */
        if (isset($action['redirect'])) {

            $data->put('redirect', Str::parse($action['redirect'], $data->toArray()));

            return;
        }

        /**
         * We at least need a stream to
         * continue figuring out a view.
         */
        if (!$stream = $data->get('stream')) {
            return;
        }

        // @todo: Stream redirects?

        /**
         * We at least need an entry to
         * continue figuring out a view.
         */
        if (!$entry = $data->get('entry')) {
            return;
        }

        // @todo: Entry data redirects?
    }

    /**
     * Resolve the response.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveResponse(Collection $data)
    {

        if ($redirect = $data->get('redirect')) {

            $data->put('response', Redirect::to($redirect, $data->get('status_code', 302)));

            return;
        }

        if ($view = $data->get('view')) {
dd($data->get('entry'));
            $data->put('response', Response::view($view, $data->all()));

            return;
        }
    }
}
