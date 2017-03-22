<?php namespace Anomaly\Streams\Platform\Search\Console;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Rebuild
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @author        Agustin Didiego <agustindidiego@gmail.com>
 * @package       Anomaly\Streams\Platform\Search\Console
 */
class Rebuild extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:rebuild';

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'search:rebuild {stream}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild a searchable stream(s).';

	/**
	 * Execute the console command.
	 *
	 * @param StreamRepositoryInterface $streams
	 */
    public function fire(
		StreamRepositoryInterface $streams
    ) {
        $stream = $this->argument('stream');

        if (strpos($stream, '.')) {
	        list($namespace, $slug) = explode('.', $stream);

	        if (!$stream = $streams->findBySlugAndNamespace($slug, $namespace)) {

		        $this->error('Stream [' . $this->argument('stream') . '] could not be found.');

		        return;
	        }

	        $this->output->progressStart(1);

	        $this->rebuildStream($stream);

        } else {
        	$namespace = $stream;

        	if(($_streams = $streams->findAllByNamespace($namespace))) {

		        $this->output->progressStart($_streams->count());

		        /** @var StreamInterface $stream */
		        foreach($_streams as $stream)
		        {
			        $this->rebuildStream($stream);
		        }
	        }

        }

        $this->output->progressFinish();
    }

	/**
	 * @param StreamInterface $stream
	 */
    protected function rebuildStream($stream)
    {
	    /* @var EntryModel $model */
	    $model = $stream->getEntryModel();

	    /**
	     * If the stream does not have a valid
	     * search configuration then we don't
	     * know how to insert it's entries.
	     */
	    if (!$model->isSearchable()) {
		    $this->output->text('Stream [' . $stream->getSlug() . '] is not searchable. Skipping.');
		    $this->output->progressAdvance();
		    return;
	    }

	    $this->output->text('Deleting ' . $stream->getSlug());

	    $model::removeAllFromSearch();

	    $this->output->text('Rebuilding ' . $stream->getSlug());

	    $model::makeAllSearchable();

	    $this->output->progressAdvance();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['stream', InputArgument::REQUIRED, 'The stream to rebuild or namespace to rebuild all streams from it: i.e. pages.pages or pages'],
        ];
    }
}
