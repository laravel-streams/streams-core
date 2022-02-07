<?php

namespace Streams\Core\Http\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\FiresCallbacks;

class EntryController extends Controller
{

    use FiresCallbacks;

    protected $steps = [
        'resolve_stream',
        'resolve_entry',
        'resolve_view',
        'resolve_redirect',
        'resolve_response',
    ];

    public function __invoke()
    {
        $data = collect();

        $data->put('route', Request::route());
        $data->put('action', Request::route()->action);

        $workflow = new Workflow(array_combine($this->steps, array_map(function ($step) {
            return [$this, Str::camel($step)];
        }, $this->steps)));

        $this->fire('handling', [
            'data' => $data,
            'workflow' => $workflow
        ]);

        $workflow
            ->passThrough($this)
            ->process(['data' => $data]);

        $this->fire('responding', ['data' => $data]);

        return $data->get('response');
    }

    public function resolveStream(Collection $data)
    {
        $action = $data->get('action');

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

    public function resolveEntry(Collection $data): void
    {
        if (!$stream = $data->get('stream')) {
            return;
        }

        $action = $data->get('action', []);

        if ($entry = Arr::get($action, 'entry')) {

            $data->put('entry', $stream->repository()->find($entry));

            return;
        }

        /**
         * Try and use the route parameters
         * to resolve an entry otherwise.
         */
        $parameters = Request::route()->parameters();

        if (isset($parameters['id'])) {

            $data->put('entry', $stream->repository()->find($parameters['id']));

            return;
        }

        if (isset($parameters['entry'])) {

            $data->put('entry', $stream->repository()->find($parameters['entry']));

            return;
        }

        //------------

        $criteria = [];

        foreach ($parameters as $key => $value) {
            if (Str::startsWith($key, 'entry__')) {
                $criteria[str_replace('entry__', '', $key)] = $value;
            }
        }

        if (!$criteria) {
            return;
        }

        $query = $stream->entries();

        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }

        $results = $query->limit(1)->get();

        if ($results->count() == 1) {

            $data->put('entry', $results->first());

            return;
        }
    }

    public function resolveView(Collection $data): void
    {
        if ($data->has('response')) {
            return;
        }

        if ($data->has('entry') && $data->get('entry') === null) {
            return;
        }

        $action = $data->get('action');

        // /**
        //  * Check if the entry is 
        //  * overriding the view.
        //  */
        // if (
        //     ($entry = $data->get('entry'))
        //     && $view = $entry->getAttribute('__view')
        // ) {

        //     $data->put('view', $view);

        //     return;
        // }

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
         * Try the stream template.
         */
        if ($stream->template) {
            $data->put('view', $stream->template);
        }

        /**
         * Fallback to the route name to try
         * and guess a view template to use.
         */
        if (!$name = Arr::get($action, 'as')) {
            return;
        }

        if (Str::is('streams::*.*', $name)) {
            $name = explode('.', str_replace('streams::', '', $name));
        }

        if (View::exists($view = "{$name[0]}.{$name[1]}")) {

            $data->put('view', $view);

            return;
        }

        if ($name[1] == 'view' && View::exists($view = Str::singular($name[0]))) {

            $data->put('view', $view);

            return;
        }
    }

    /**
     * Resolve the redirect.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveRedirect(Collection $data)
    {

        $action = $data->get('action');

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

        /**
         * Check if the entry is 
         * overriding the view.
         */
        if (
            $entry
            && $redirect = $entry->getAttribute('streams__redirect')
        ) {

            $data->put('response', Redirect::to($redirect));

            return;
        }
    }

    /**
     * Resolve the response.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveResponse(Collection $data)
    {
        if ($data->has('response')) {
            return;
        }

        if ($data->has('entry') && $data->get('entry') === null) {

            $data->put('response', abort(404));

            return;
        }

        if ($redirect = $data->get('redirect')) {

            $data->put('response', Redirect::to($redirect, $data->get('status_code', 302)));

            return;
        }

        if ($view = $data->get('view')) {

            $data->put('response', Response::view($view, $data->all()));

            return;
        }
    }
}
