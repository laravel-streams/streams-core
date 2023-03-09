<?php

namespace Streams\Core\Tests\Field\Decorator;

use Illuminate\Support\Collection;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Types\BooleanFieldType;

class BooleanDecoratorTest extends CoreTestCase
{
    public function test_it_returns_boolean()
    {
        $decorator = (new BooleanFieldType())->decorate(true);

        $this->assertTrue($decorator->isTrue());
        $this->assertTrue($decorator->is(true));
        $this->assertFalse($decorator->isFalse());
    }

    public function test_it_returns_text_label()
    {
        $decorator = (new BooleanFieldType())->decorate(true);

        $this->assertSame('On', __($decorator->text()));
        $this->assertSame('+', __($decorator->text('+', '-')));

        $decorator = (new BooleanFieldType())->decorate(false);

        $this->assertSame('Off', __($decorator->text()));
        $this->assertSame('-', __($decorator->text('+', '-')));
    }
}
