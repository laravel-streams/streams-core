<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Arr;
use Streams\Core\Tests\CoreTestCase;

class ArrHtmlAttributesTest extends CoreTestCase
{
    public function test_it_exports_html_attributes()
    {
        $this->assertEquals(
            'foo="bar" baz="qux"',
            Arr::htmlAttributes(['foo' => 'bar', 'baz' => 'qux'])
        );
    }

    public function test_it_supports_boolean_attributes()
    {
        $this->assertEquals(
            'foo bar',
            Arr::htmlAttributes(['foo' => true, 'bar'])
        );
    }

    public function test_it_implodes_arrays_for_class()
    {
        $this->assertEquals(
            'class="foo bar"',
            Arr::htmlAttributes(['class' => ['foo', 'bar']])
        );
    }
}
