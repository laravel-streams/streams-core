<?php

namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Streams\Facades\Streams;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryModel
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 *
 */
class EntryModel extends Model implements EntryInterface
{

    /**
     * The entry stream.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Return the stream.
     * 
     * @return StreamInterface
     */
    public function stream()
    {
        return $this->stream ?: Streams::make($this->table);
    }

    /**
     * Set the stream.
     *
     * @param StreamInterface $stream
     */
    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }
}
