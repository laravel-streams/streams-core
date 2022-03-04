<?php

namespace Streams\Core\Tests;

use Illuminate\Database\Eloquent\Model;
use Streams\Core\Support\Traits\Streams;

class EloquentModel extends Model
{
    use Streams;

    public $stream = 'films';
}
