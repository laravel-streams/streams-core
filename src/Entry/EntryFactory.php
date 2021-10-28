<?php

namespace Streams\Core\Entry;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Validation\Validator;
use Streams\Core\Field\Type\Datetime;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Entry\Contract\EntryInterface;

class EntryFactory
{

    use Macroable {
        Macroable::__call as private callMacroable;
    }

    use HasMemory;

    public int $count = 1;

    public Stream $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function create($data = []): EntryInterface
    {
        $this->stream->fields->each(function ($field) use (&$data) {
            if (!array_key_exists($field->handle, $data)) {
                $data[$field->handle] = $field->type()->factory()->create();
            }
        });

        return $this->stream->repository()->newInstance($data);
    }
}
