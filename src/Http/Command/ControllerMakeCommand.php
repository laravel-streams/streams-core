<?php namespace Anomaly\Streams\Platform\Http\Command;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ControllerMakeCommand
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControllerMakeCommand extends \Illuminate\Routing\Console\ControllerMakeCommand
{
    use DispatchesJobs;

    protected $addon;

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException | Exception
     */
    public function handle()
    {

        if($this->hasOption('addon')) {

            if(!$addon = $this->dispatch(new GetAddon($this->option('addon')))) {
                throw new \Exception("Addon could not be found.");
            }

            $this->addon = $addon;
        }

        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {

        if(!$this->hasOption('addon')) {
            return parent::getStub();
        }

        return __DIR__.'/../../../resources/stubs/controllers/controller.stub';
    }

   /**
     * Get the root namespace for the class.
     *
     * @return string
     */
   protected function rootNamespace()
    {
        if(!$this->hasOption('addon')) {
            return parent::rootNamespace();
        }

        return $this->addon->getTransformedClass();
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        if(!$this->hasOption('addon')) {
            return parent::getPath($name);
        }

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->addon->getAppPath(str_replace('\\', '/', $name).'.php');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $parentOptions = parent::getOptions();

        return array_merge($parentOptions,[
            ['addon', 'a', InputOption::VALUE_REQUIRED, 'Generate a controller class for the give addon'],
        ]);
    }

}
