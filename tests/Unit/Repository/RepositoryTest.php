<?php

use Tests\TestCase;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

class RepositoryTest extends TestCase
{
    public function testAll()
    {
        $this->assertInstanceOf(Collection::class, $this->repository()->all());
    }

    public function testFind()
    {
        $this->assertNull($this->repository()->find('null_widget'));
        $this->assertInstanceOf(EntryInterface::class, $this->repository()->find('foo_widget'));
    }

    public function testFindBy()
    {
        $this->assertNull($this->repository()->findBy('non_field', 'bogus_value'));
        $this->assertInstanceOf(EntryInterface::class, $this->repository()->findBy('secret', 'itsasecret'));
    }

    public function testFindAll()
    {
        $this->assertInstanceOf(Collection::class, $this->repository()->findAll([
            'bar_widget',
            'foo_widget',
        ]));
    }

    public function testFindAllBy()
    {
        $this->assertInstanceOf(Collection::class, $this->repository()->findAllBy('type', 'testing'));
    }

    public function testCount()
    {
        $this->assertGreaterThan(0, $this->repository()->count());
    }

    public function testCreate()
    {
        $this->assertInstanceOf(EntryInterface::class, $this->repository()->create([
            'id' => 'test_widget',
            'name' => 'Test Widget',
        ]));

        $this->cleanup('test_widget');
    }

    public function testDelete()
    {
        $this->markTestIncomplete();

        $this->repository()->create([
            'id' => 'test_widget',
            'name' => 'Test Widget',
        ]);

        $entry = $this->repository()->find('test_widget');
        //$entry2 = $this->repository()->find('test_widget_faker');

        $this->assertTrue($this->repository()->delete($entry));
        // @todo finish
        //$this->assertFalse($this->repository()->delete($entry2));
    }

    public function testSave()
    {
        $this->repository()->create([
            'id' => 'saved_widget',
            'name' => 'Saved Widget',
        ]);


        $entry = $this->repository()->find('saved_widget');

        $entry->new_attribute = 'foo_bar';

        $this->assertTrue($this->repository()->save($entry));


        $entry = $this->repository()->find('saved_widget');

        $this->assertTrue($entry->new_attribute == 'foo_bar');

        $this->cleanup('saved_widget');
    }

    /**
     * Return the testing stream repository.
     */
    protected function repository()
    {
        return (new Stream(json_decode(file_get_contents(realpath(__DIR__ . '/../../streams/data/widgets.json')), true)))->repository();
    }

    /**
     * Cleanup entries.
     * 
     * @param $id
     */
    protected function cleanup($id)
    {
        if ($garbage = $this->repository()->find($id)) {
            $this->repository()->delete($garbage);
        }
    }
}
