<?php

namespace Streams\Core\Http\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\FiresCallbacks;

class EntryController extends Controller
{

    use FiresCallbacks;

    public function __invoke()
    {
        $data = collect();

        $data->put('route', Request::route());
        $data->put('action', Request::route()->action);

        $this->resolveStream($data);
        $this->resolveEntry($data);
        $this->resolveView($data);
        $this->resolveRedirect($data);
        $this->resolveResponse($data);

        return $data->get('response') ?: abort(404);
    }

    protected function resolveStream(Collection $data): void
    {
        $action = $data->get('action');

        if (isset($action['stream'])) {

            $data->put('stream', Streams::make($action['stream']));

            return;
        }

        $parameters = Request::route()->parameters;

        if (isset($parameters['stream'])) {

            $data->put('stream', Streams::make($parameters['stream']));

            return;
        }
    }

    protected function resolveEntry(Collection $data): void
    {
        if (!$stream = $data->get('stream')) {
            return;
        }

        $action = $data->get('action', []);

        if ($entry = Arr::get($action, 'entry')) {

            $data->put('entry', $stream->repository()->find($entry));

            return;
        }

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

    protected function resolveView(Collection $data): void
    {
        $action = $data->get('action');

        if (isset($action['view'])) {

            $data->put('view', $action['view']);

            return;
        }

        $name = Arr::get($action, 'as');

        if ($name && View::exists($name)) {

            $data->put('view', $name);

            return;
        }

        $stream = $data->get('stream');
        $entry = $data->get('entry');

        if (!$stream) {
            return;
        }

        $plural = Str::plural($stream->id);
        $singular = Str::singular($stream->id);

        if ($entry && View::exists($singular)) {

            $data->put('view', $singular);

            return;
        }

        if (!$entry && View::exists($plural)) {

            $data->put('view', $plural);

            return;
        }

        return;
    }

    protected function resolveRedirect(Collection $data): void
    {
        $action = $data->get('action');

        if (isset($action['redirect'])) {

            $data->put('redirect', Str::parse($action['redirect'], $data->toArray()));

            return;
        }
    }

    protected function resolveResponse(Collection $data): void
    {
        if ($data->has('entry') && $data->get('entry') === null) {
            abort(404);
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
