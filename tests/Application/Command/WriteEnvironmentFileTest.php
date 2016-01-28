<?php

class WriteEnvironmentFileTest extends TestCase
{

    use \Illuminate\Foundation\Bus\DispatchesJobs;

    public function testCanWriteEnvironmentFile()
    {
        $this->dispatch(
            new \Anomaly\Streams\Platform\Application\Command\WriteEnvironmentFile(
                array_merge(
                    $this->dispatch(new \Anomaly\Streams\Platform\Application\Command\ReadEnvironmentFile()),
                    ['DUMMY_TEST' => ($time = time())]
                )
            )
        );

        $data = $this->dispatch(new \Anomaly\Streams\Platform\Application\Command\ReadEnvironmentFile());

        $this->assertTrue($data['DUMMY_TEST'] == $time);
    }
}
