<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Streams\Core\Support\Facades\Streams;
use GoldSpecDigital\ObjectOrientedOAS\OpenApi;
use Streams\Core\Support\Traits\FiresCallbacks;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Info;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Server;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Contact;
use GoldSpecDigital\ObjectOrientedOAS\Objects\License;
use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Operation;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Components;

class StreamSchema
{
    use FiresCallbacks;

    protected Stream $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    // @todo move to API package
    public function api()
    {
        return OpenApi::create()
            ->openapi(OpenApi::OPENAPI_3_0_2)
            ->info(Info::create()
                ->title('Streams API Specification')
                ->version('v1')
                ->description('For using the "streams/api" package.')
                ->termsOfService(url('terms'))
                ->contact(Contact::create()
                    ->name('API Team')
                    ->email('apiteam@example.io')
                    ->url('http://example.io'))
                ->license(License::create()
                    ->name('Apache 2.0')
                    ->url('https://www.apache.org/licenses/LICENSE-2.0.html')))
            ->paths(...$this->paths())
            ->tags(...$this->tags())
            ->servers(Server::create()
                ->url(url(config('streams.api.prefix'))))
            ->components(Components::create()
                ->schemas(...$this->components()));
    }

    // @todo move to API package
    public function components()
    {
        return Streams::collection()->map(function ($stream) {
            return $stream->schema()->object();
        })->all();
    }

    // @todo move to API package
    public function tags()
    {
        return Streams::collection()->map(function ($stream) {
            return $stream->schema()->tag();
        })->all();
    }

    // @todo move to API package
    public function paths()
    {
        $paths = [];

        Streams::collection()->map(function ($stream) use (&$paths) {
            $paths[] = $this->entries($stream);
            $paths[] = $this->entry($stream);
        })->all();

        return $paths;
    }

    // @todo move to API package
    public function entries(Stream $stream)
    {
        $get = Operation::get()
            ->responses(Response::create()
                ->statusCode(200)
                ->description('OK')
                ->content(
                    MediaType::json()->schema($stream->schema()->object())
                ))
            ->tags($stream->schema()->tag())
            ->summary('Show multiple entries.')
            ->operationId($stream->id . '.show');

        $post = Operation::post()
            ->responses(Response::create()
                ->statusCode(200)
                ->description('OK')
                ->content(
                    MediaType::json()->schema($stream->schema()->object())
                ))
            ->tags($stream->schema()->tag())
            ->summary('Create a new entry.')
            ->operationId($stream->id . '.create');

        return PathItem::create()
            ->route('/api/streams/users/entries')
            ->operations($get, $post);
    }

    // @todo move to API package
    public function entry(Stream $stream)
    {
        $get = Operation::get()
            ->responses(Response::create()
                ->statusCode(200)
                ->description('OK')
                ->content(
                    MediaType::json()->schema($stream->schema()->object())
                ))
            ->tags($stream->schema()->tag())
            ->summary('Show an individual entry.')
            ->operationId($stream->id . '.show');

        $put = Operation::put()
            ->responses(Response::create()
                ->statusCode(200)
                ->description('OK')
                ->content(
                    MediaType::json()->schema($stream->schema()->object())
                ))
            ->tags($stream->schema()->tag())
            ->summary('Update an entry.')
            ->operationId($stream->id . '.update');

        $patch = Operation::patch()
            ->responses(Response::create()
                ->statusCode(200)
                ->description('OK')
                ->content(
                    MediaType::json()->schema($stream->schema()->object())
                ))
            ->tags($stream->schema()->tag())
            ->summary('Patch an entry.')
            ->operationId($stream->id . '.patch');

        $delete = Operation::delete()
            ->responses(Response::create()
                ->statusCode(204)
                ->description('OK'))
            ->tags($stream->schema()->tag())
            ->summary('Delete an existing entry.')
            ->operationId($stream->id . '.delete');

        return PathItem::create()
            ->route('/api/streams/users/entries/{id}')
            ->operations($get, $put, $patch, $delete);
    }




    public function tag()
    {
        return Tag::create()
            ->name(__($this->stream->name) ?: Str::humanize($this->stream->id))
            ->description(__($this->stream->description));
    }

    public function object()
    {
        return Schema::object($this->stream->id)
            ->properties(...$this->properties());
    }

    public function properties()
    {
        return $this->stream->fields->map(function ($field) {
            return $field->schema();
        })->all();
    }
}
