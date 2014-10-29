<?php namespace Anomaly\Streams\Platform\Console;

class Kernel extends \Illuminate\Foundation\Console\Kernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Run the console application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    public function handle($input, $output = null)
    {
        if ($input->getFirstArgument() === 'run') {
            return 1;
        }

        try {

            return parent::handle($input, $output);

        } catch (\Exception $e) {

            $output->writeln((string)$e);

            return 1;
            
        }
    }

}
