<?php

namespace Streams\Core\Tests\Stream\Criteria\Adapter;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Pagination\AbstractPaginator;

class FileAdapterTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        $this->tearDown();

        Streams::load(base_path('vendor/streams/core/tests/planets.json'));
        Streams::load(base_path('vendor/streams/core/tests/planets_csv.json'));
    }

    public function testCanReturnResults()
    {
        $first = Streams::entries('testing.planets')->first();
        $second = Streams::entries('testing.planets')->find('alderaan');
        $collection = Streams::entries('testing.planets')->get();

        $this->assertEquals(9, $collection->count());
        $this->assertEquals("Tatooine", $first->name);
        $this->assertEquals("Alderaan", $second->name);

        $this->assertInstanceOf(Entry::class, $first);
        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function testCanOrderResults()
    {
        $this->assertEquals(
            "Yavin IV",
            Streams::entries('testing.planets')
                ->orderBy('name', 'desc')
                ->first()->name
        );
    }

    public function testCanLimitResults()
    {
        $this->assertEquals(
            "Alderaan",
            Streams::entries('testing.planets')
                ->limit(1, 1)
                ->get()
                ->first()->name
        );
    }

    public function testCanConstrainResults()
    {
        $this->assertEquals(
            1,
            Streams::entries('testing.planets')
                ->where('name', 'Hoth')
                ->get()
                ->count()
        );

        $this->assertEquals(
            5,
            Streams::entries('testing.planets')
                ->where('orbital_period', '>=', 365)
                ->get()->count()
        );

        // $this->assertEquals(
        //     2,
        //     Streams::entries('testing.planets')
        //         ->where('orbital_period', '>=', 365)
        //         ->orWhere('name', 'First Example')
        //         ->get()->count()
        // );

        $this->assertEquals(
            'Endor',
            Streams::entries('testing.planets')
                ->where('name', 'Endor')
                ->first()->name
        );
    }

    public function testCanCountResults()
    {
        $this->assertEquals(9, Streams::entries('testing.planets')->count());

        $this->assertEquals(1, Streams::entries('testing.planets')->where('name', 'Endor')->count());
    }

    public function testCanPaginateResults()
    {
        $pagination = Streams::entries('testing.planets')->paginate(10);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(9, $pagination->total());


        $pagination = Streams::entries('testing.planets')->paginate([
            'per_page' => 1
        ]);

        $this->assertInstanceOf(AbstractPaginator::class, $pagination);
        $this->assertEquals(9, $pagination->total());
    }

    public function testCanReturnNewInstances()
    {
        $entry = Streams::entries('testing.planets')->newInstance([
            'name' => 'Earth',
            'climate' => "temperate",
            'rotation_period' => 24,
            'orbital_period' => 365,
        ]);

        $this->assertEquals('Earth', $entry->name);
    }

    public function testCanCreateAndDeleteJsonFormat()
    {
        $entry = Streams::entries('testing.planets')->newInstance([
            'id' => 'earth',
            'name' => 'Earth',
            'climate' => "temperate",
            'rotation_period' => 24,
            'orbital_period' => 365,
        ]);

        Streams::repository('testing.planets')->save($entry);
        
        $this->assertEquals(10, Streams::entries('testing.planets')->count());

        Streams::repository('testing.planets')->delete($entry);

        $this->assertEquals(9, Streams::entries('testing.planets')->count());


        $entry = Streams::entries('testing.planets')->create([
            'id' => 'earth',
            'name' => 'Earth',
            'climate' => "temperate",
            'rotation_period' => 24,
            'orbital_period' => 365,
        ]);

        $this->assertEquals('Earth', $entry->name);
        $this->assertEquals(10, Streams::entries('testing.planets')->count());
    }

    public function testCanCreateAndDeleteCsvFormat()
    {
        $entry = Streams::entries('testing.planets_csv')->newInstance([
            'id' => 'earth',
            'name' => 'Earth',
            'climate' => "temperate",
            'rotation_period' => 24,
            'orbital_period' => 365,
        ]);
        
        Streams::repository('testing.planets_csv')->save($entry);

        $this->assertEquals(10, Streams::entries('testing.planets_csv')->count());
        
        Streams::repository('testing.planets_csv')->delete($entry);

        $this->assertEquals(9, Streams::entries('testing.planets_csv')->count());


        $entry = Streams::entries('testing.planets_csv')->create([
            'id' => 'earth',
            'name' => 'Earth',
            'climate' => "temperate",
            'rotation_period' => 24,
            'orbital_period' => 365,
        ]);

        $this->assertEquals('Earth', $entry->name);
        $this->assertEquals(10, Streams::entries('testing.planets_csv')->count());
    }

    public function testCanTruncate()
    {
        Streams::repository('testing.planets')->truncate();

        $this->assertEquals(0, Streams::entries('testing.planets')->count());

        $this->setUp();
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $json = base_path('vendor/streams/core/tests/data/planets.json');
        $csv = base_path('vendor/streams/core/tests/data/planets.csv');

        if (file_exists($json)) {
            unlink($json);
        }

        if (file_exists($csv)) {
            unlink($csv);
        }

        copy($json . '.bak', $json);
        copy($csv . '.bak', $csv);
    }
}
