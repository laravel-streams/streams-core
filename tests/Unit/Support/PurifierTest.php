<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Support\Purifier;

class PurifierTest extends TestCase
{
    public function testPurifiesHtml()
    {
        app('files')->deleteDirectory(app_storage_path('support/purifier'));

        $purifier = app(Purifier::class);

        $this->assertEquals('Hello', $purifier->purify('Hello<script>alert();</script>'));
        $this->assertEquals('Hello<div></div>', $purifier->purify('Hello<DIV STYLE="background-image:url(javascript:alert(\'XSS\'))">'));
    }

    public function testPreservesPre()
    {
        $purifier = app(Purifier::class);

        $this->assertEquals('Hello<pre>alert();</pre>', $purifier->purify('Hello<pre>alert();</pre>'));
    }

    public function testPreservesCode()
    {
        $purifier = app(Purifier::class);

        $this->assertEquals('Hello<code>alert();</code>', $purifier->purify('Hello<code>alert();</code>'));
    }
}
