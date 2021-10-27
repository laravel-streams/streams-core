<?php

namespace Streams\Core\Exception;

use Streams\Core\Stream\Stream;
use Throwable;

class EntryAlreadyExistsException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function make($key, Stream $stream)
    {
        return new static("Entry with key [{$key}] already exists in stream [{$stream->handle}]");
    }

}
