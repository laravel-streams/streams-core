<?php

class ReloadEnvironmentFileTest extends TestCase
{

    use \Illuminate\Foundation\Bus\DispatchesJobs;

    public function testCanReadEnvironmentFile()
    {
        $this->dispatch(
            new \Anomaly\Streams\Platform\Application\Command\WriteEnvironmentFile(
                array_merge(
                    $this->dispatch(new \Anomaly\Streams\Platform\Application\Command\ReadEnvironmentFile()),
                    ['DUMMY_TEST' => ($time = time())]
                )
            )
        );

        $this->dispatch(new \Anomaly\Streams\Platform\Application\Command\ReloadEnvironmentFile());

        $this->assertTrue(env('DUMMY_TEST') == $time);
    }
}
