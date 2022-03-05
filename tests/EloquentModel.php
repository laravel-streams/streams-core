<?php

namespace Streams\Core\Tests;

use Illuminate\Database\Eloquent\Model;
use Streams\Core\Support\Traits\Streams;
use Streams\Core\Entry\Contract\EntryInterface;

class EloquentModel extends Model implements EntryInterface
{
    use Streams;

    public $stream = 'films';
}
