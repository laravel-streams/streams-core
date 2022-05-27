<?php

namespace Streams\Core\Tests\Support\Traits;

use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\DB;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Tests\EloquentModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Validation\Validator;
use Streams\Core\Field\Decorator\StringDecorator;

class StreamsTest extends CoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('films');

        Schema::create('films', function (Blueprint $table) {
            $table->id('episode_id');
            $table->dateTime('created')->nullable();
            $table->dateTime('edited')->nullable();
            $table->string('title')->nullable();
            $table->text('opening_crawl')->nullable();
            $table->string('director')->nullable();
            $table->string('producer')->nullable();
            $table->date('release_date')->nullable();
            $table->string('characters')->nullable();
            $table->string('starships')->nullable();
            $table->string('vehicles')->nullable();
            $table->string('planets')->nullable();
            $table->string('species')->nullable();
        });

        foreach (Streams::entries('films')->get() as $film) {

            $data = $film->toArray();

            $data['characters'] = json_encode($data['characters']);
            $data['starships'] = json_encode($data['starships']);
            $data['vehicles'] = json_encode($data['vehicles']);
            $data['planets'] = json_encode($data['planets']);
            $data['species'] = json_encode($data['species']);

            DB::table('films')->insert($data);
        }

        Streams::extend('films', [
            'config' => [
                'source' => [
                    'type' => 'eloquent',
                    'model' => \Streams\Core\Tests\EloquentModel::class,
                ],
            ],
        ]);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('films');

        parent::tearDown();
    }

    public function test_it_boots_trait()
    {
        $entry = new EloquentModel();

        $entry->stream = 'films';

        $this->assertInstanceOf(Stream::class, $entry->stream());
    }

    public function test_it_fills_prototype_and_model()
    {
        $entry = new EloquentModel();

        $entry->stream = 'films';

        $entry->fill($this->filmData());

        $this->assertSame('Star Wars: The Last Jedi', $entry->title);
    }

    public function test_it_sets_attributes_prototype_and_model()
    {
        $entry = new EloquentModel();

        $entry->stream = 'films';

        $entry->setAttributes($this->filmData());

        $this->assertSame('Star Wars: The Last Jedi', $entry->title);
    }

    public function test_it_sets_specific_attribute_prototype_and_model()
    {
        $entry = new EloquentModel();

        $entry->stream = 'films';

        $entry->setAttribute('title', 'Star Wars: The Last Jedi');

        $this->assertSame('Star Wars: The Last Jedi', $entry->title);
    }

    public function test_it_detects_attributes()
    {
        $entry = new EloquentModel();

        $entry->stream = 'films';

        $this->assertFalse($entry->hasAttribute('title'));
    }

    public function test_it_decorates_fields()
    {
        $entry = new EloquentModel();

        $entry->stream = 'films';

        $entry->setAttributes($this->filmData());

        $this->assertInstanceOf(StringDecorator::class, $entry->decorate('title'));
    }

    public function test_it_returns_a_validator()
    {
        $entry = new EloquentModel();

        $entry->stream = 'films';

        $entry->setAttributes($this->filmData());

        $this->assertInstanceOf(Validator::class, $entry->validator());
    }

    public function test_it_supports_attribute_access()
    {
        $entry = new EloquentModel([
            'title' => 'Test Title',
        ]);

        $entry->stream = 'films';

        $entry->title = 'Test Title';

        $this->assertSame('Test Title', $entry->title);
    }

    public function test_it_sets_raw_attributes()
    {
        $entry = new EloquentModel([
            'title' => 'Test Title',
        ]);

        $entry->stream = 'films';

        $entry->setRawAttributes($this->filmData());

        $this->assertSame(['title' => 'Test Title'], $entry->getOriginal());
        
        $this->assertSame($this->filmData(), $entry->getAttributes());
    }
    
    // public function test_it_trims_strict_attributes()
    // {
    //     $entry = new EloquentModel($this->filmData());

    //     $entry->stream = 'films';

    //     $entry->foo = 'Bar';

    //     $this->assertSame($this->filmData(), $entry->strict());
    // }
    
    public function test_it_returns_dates()
    {
        $entry = new EloquentModel($this->filmData());

        $entry->stream = 'films';

        $entry->created = '2021-12-15';

        $this->assertInstanceOf(\DateTime::class, $entry->created);
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
