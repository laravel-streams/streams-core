<?php

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Ui\Button\Button;

class ButtonTest extends TestCase
{
    public function testArrayable()
    {
        $button = $this->button();

        $this->assertInstanceOf(Arrayable::class, $button);
        $this->assertTrue(is_array($button->toArray()));
    }

    public function testJsonable()
    {
        $button = $this->button();

        $this->assertInstanceOf(Jsonable::class, $button);
        $this->assertTrue(is_array($button->toArray()));
    }

    public function testAttributes()
    {
        $button = $this->button();

        $button->setAttribute('foo', 'bar');

        $this->assertTrue($button->foo === 'bar');
    }

    public function testOpen()
    {
        $this->assertTrue(Str::startsWith($this->button()->open(), '<a'));
    }

    public function testClose()
    {
        $this->assertTrue($this->button(['tag' => 'button'])->close() == '</button>');
    }

    /**
     * @param array $attributes
     * @return Button
     */
    protected function button(array $attributes = [])
    {
        return (new Button(array_merge([
            'tag' => 'a',
        ], $attributes)));
    }
}
