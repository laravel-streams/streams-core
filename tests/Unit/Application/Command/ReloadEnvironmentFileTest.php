<?php

class ReloadEnvironmentFileTest extends TestCase
{

    use \Illuminate\Foundation\Bus\DispatchesJobs;

    public function testCanReadEnvironmentFile()
    {
        $this->markTestSkipped('We should not be touching the file.');

        return;

        dispatch_sync(
            new \Anomaly\Streams\Platform\Application\Command\WriteEnvironmentFile(
                array_merge(
                    dispatch_sync(new \Anomaly\Streams\Platform\Application\Command\ReadEnvironmentFile()),
                    ['DUMMY_TEST' => ($time = time())]
                )
            )
        );

        dispatch_sync(new \Anomaly\Streams\Platform\Application\Command\ReloadEnvironmentFile());

        $this->assertTrue(env('DUMMY_TEST') == $time);
    }
}
