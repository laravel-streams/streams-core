<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ColorFieldType;
use Streams\Core\Field\Decorator\ColorDecorator;

class ColorDecoratorTest extends CoreTestCase
{
    public function test_it_validates_hex()
    {
        $this->expectException(\Exception::class);
        
        $decorator = (new ColorFieldType())->decorate('#ff000');

        $this->assertSame(255, $decorator->red());
    }

    public function test_it_creates_from_hex()
    {
        $decorator = (new ColorFieldType())->decorate('#ff0000');

        $this->assertSame(255, $decorator->levels()['red']);
        $this->assertSame(0, $decorator->levels()['blue']);
        $this->assertSame(0, $decorator->levels()['green']);
    }

    public function test_it_creates_from_rgb()
    {
        $decorator = (new ColorFieldType())->decorate('rgb(255, 0, 0)');

        $this->assertSame(255, $decorator->levels()['red']);
        $this->assertSame(0, $decorator->levels()['blue']);
        $this->assertSame(0, $decorator->levels()['green']);
    }

    public function test_it_validates_rgb()
    {
        $this->expectException(\Exception::class);
        
        $decorator = (new ColorFieldType())->decorate('rg(255, 0, 0)');

        $this->assertSame(255, $decorator->red());
    }

    public function test_it_creates_from_rgba()
    {
        $decorator = (new ColorFieldType())->decorate('rgba(255, 0, 0, 0.5)');

        $this->assertSame(255, $decorator->levels()['red']);
        $this->assertSame(0, $decorator->levels()['blue']);
        $this->assertSame(0, $decorator->levels()['green']);
        $this->assertSame(0.5, $decorator->levels()['alpha']);

        $decorator = (new ColorFieldType())->decorate('rgba(255, 0, 0, 0)');

        $this->assertSame(0, $decorator->levels()['alpha']);
    }

    public function test_it_validates_rgba()
    {
        $this->expectException(\Exception::class);
        
        $decorator = (new ColorFieldType())->decorate('rgba(255, 0, 0)');

        $this->assertSame(255, $decorator->red());
    }

    public function test_it_returns_configured_output()
    {
        $decorator = (new ColorFieldType([
            'config' => [
                'format' => 'rgb',
            ]
        ]))->decorate('#ff0000');

        $this->assertSame('rgb(255, 0, 0)', $decorator->output());
    }

    public function test_it_returns_hex_code()
    {
        $decorator = (new ColorFieldType())->decorate('rgb(255, 0, 0)');

        $this->assertSame('#ff0000', $decorator->hex());
    }

    public function test_it_returns_code_only()
    {
        $decorator = (new ColorFieldType())->decorate('#ff0000');

        $this->assertSame('ff0000', $decorator->code());
    }

    public function test_it_returns_rgb()
    {
        $decorator = (new ColorFieldType())->decorate('#ff0000');

        $this->assertSame('rgb(255, 0, 0)', $decorator->rgb());
    }

    public function test_it_returns_rgba()
    {
        $decorator = (new ColorFieldType())->decorate('#ff0000');

        $this->assertSame('rgba(255, 0, 0, 1)', $decorator->rgba());
    }

    public function test_it_returns_levels()
    {
        $decorator = (new ColorFieldType())->decorate('#ff0000');

        $this->assertSame(255, $decorator->red());
        $this->assertSame(0, $decorator->blue());
        $this->assertSame(0, $decorator->green());
        
        $this->assertSame([
            'red' => 255,
            'green' => 0,
            'blue' => 0,
            'alpha' => 1,
        ], $decorator->levels());
    }
}
