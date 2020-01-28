<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Support\Str;

class StrTest extends TestCase
{

    public function testCanHumanizeString()
    {
        $this->assertEquals('ryan thompson', (new Str())->humanize('ryan_thompson'));
    }

    public function testCanTruncateString()
    {
        $this->assertEquals('Ryan...', (new Str())->truncate('Ryan Thompson', 7));
        $this->assertEquals('Ryan Thompson', (new Str())->truncate('Ryan Thompson', 13));
    }

    public function testCanLinkifyString()
    {
        $this->assertEquals('Link:<a href="https://test.com">https://test.com</a>', (new Str())->linkify('Link:https://test.com'));
    }

    public function testCanPurifyHtml()
    {
        app('files')->deleteDirectory(app_storage_path('support/purifier'));

        $this->assertEquals('Hello', (new Str())->purify('Hello<script>alert();</script>'));
        $this->assertEquals('Hello<div></div>', (new Str())->purify('Hello<DIV STYLE="background-image:url(javascript:alert(\'XSS\'))">'));
    }
}
