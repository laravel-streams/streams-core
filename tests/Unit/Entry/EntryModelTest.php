<?php

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Tests\TestCase;

class EntryModelTest extends TestCase
{

    public function testCanReturnStreamInstance()
    {
        $this->assertTrue((new EntryModelStub())->stream() instanceof StreamInterface);
    }

    public function testReturnsStreamInstanceViaAttribute()
    {
        $this->assertTrue((new EntryModelStub())->stream instanceof StreamInterface);
    }
}

class EntryModelStub extends EntryModel
{
    protected $stream = [
        'slug'         => 'users',
        'title_column' => 'display_name',
        'trashable'    => true,
        'versionable'  => true,
        'searchable'   => true,
        'fields' => [
            'name'        => [
                'required' => true,
                'unique'   => true,
                'type'     => 'anomaly.field_type.text',
            ],
        ],
    ];
}
