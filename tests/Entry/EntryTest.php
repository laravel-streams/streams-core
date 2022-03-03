<?php

namespace Streams\Core\Tests\Entry;

use Carbon\Carbon;
use Streams\Core\Entry\Entry;
use Streams\Core\Field\Value\IntegerValue;
use Streams\Core\Stream\Stream;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;

class EntryTest extends CoreTestCase
{

    public function test_it_is_arrayable()
    {
        $this->assertIsArray(Streams::entries('films')->first()->toArray());
    }

    public function test_it_is_jsonable()
    {
        $this->assertJson(Streams::entries('films')->first()->toJson());
        $this->assertJson(json_encode(Streams::entries('films')->first()));
    }

    public function test_it_casts_to_string_as_json()
    {
        $this->assertJson((string) Streams::entries('films')->first());
    }

    public function test_it_returns_its_stream()
    {
        $entry = Streams::entries('films')->first();

        $this->assertInstanceOf(Stream::class, $entry->stream());
    }

    public function test_it_removes_non_defined_attributes()
    {
        $entry = Streams::repository('films')->newInstance($this->filmData());

        $entry->foo_bar = 'Baz';

        $this->assertEquals('Baz', $entry->foo_bar);

        $entry->strict();

        $this->assertNull($entry->foo_bar);
    }

    public function test_it_returns_last_modified()
    {
        $entry = Streams::repository('films')->find(4);

        $this->assertInstanceOf(Carbon::class, $entry->lastModified());
    }

    public function test_it_supports_macros()
    {
        Entry::macro('episode', function() {
            return 'ID: ' . $this->episode_id;
        });

        $entry = Streams::repository('films')->find(4);

        $this->assertSame('ID: 4', $entry->episode());
    }

    public function test_it_automatically_decorates_fields()
    {
        $entry = Streams::repository('films')->find(4);

        $this->assertInstanceOf(IntegerValue::class, $entry->episodeId());
    }

    public function test_it_throws_exceptions_for_unmapped_methods()
    {
        $entry = Streams::repository('films')->find(4);

        $this->expectException(\Exception::class);

        $entry->noSuchMethod();
    }

    public function test_it_can_save()
    {
        $entry = Streams::repository('films')->newInstance($this->filmData());

        $result = $entry->save();

        $this->assertTrue($result);

        $entry = Streams::repository('films')->find(8);

        $this->assertInstanceOf(Entry::class, $entry);

        $entry->title = 'New Title';

        $entry->save();

        $entry = Streams::repository('films')->find(8);
        
        $this->assertEquals('New Title', $entry->title);
    }

    public function test_it_can_delete()
    {
        $entry = Streams::repository('films')->newInstance($this->filmData());

        $result = $entry->save();

        $this->assertTrue($result);

        $entry = Streams::repository('films')->find(8);
        
        $result = $entry->delete();

        $this->assertTrue($result);
    }

    protected function filmData()
    {
        return [
            'title' => 'Star Wars: The Last Jedi',
            'director' => 'Rian Johnson',
            'producer' => 'Kathleen Kennedy, Ram Bergman, J. J. Abrams',
            'release_date' => '2017-12-15',
            'opening_crawl' => 'The FIRST ORDER reigns. Having decimated the peaceful Republic, Supreme Leader Snoke now deploys his merciless legions to seize military control of the galaxy.

Only General Leia Organa\'s band of RESISTANCE fighters stand against the rising tyranny, certain that Jedi Master Luke Skywalker will return and restore a spark of hope to the fight.

"But the Resistance has been exposed. As the First Order speeds toward the rebel base, the brave heroes mount a desperate escape....',
            'characters' => [1, 5],
            'planets' => [],
            'starships' => [9],
            'species' => [1],
        ];
    }
}
