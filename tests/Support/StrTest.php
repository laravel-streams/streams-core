<?php

class StrTest extends TestCase
{

    public function testCanHumanizeString()
    {
        $this->assertEquals('Ryan Thompson', (new \Anomaly\Streams\Platform\Support\Str())->humanize('ryan_thompson'));
    }

    public function testCanTruncateString()
    {
        $this->assertEquals('Ryan...', (new \Anomaly\Streams\Platform\Support\Str())->truncate('Ryan Thompson', 7));
    }
}
