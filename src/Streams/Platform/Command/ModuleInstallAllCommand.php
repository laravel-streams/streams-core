<?php namespace Streams\Platform\Command;

use Illuminate\Console\Command as BaseCommand;

class  ModuleInstallAllCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'streams:module-install-all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install a module.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        foreach(app()->make('streams.modules')->getAll() as $addon) {

            $name = ucfirst($addon->slug);

            if (!app()->make('streams.modules')->get($addon->slug)) {
                $this->error("{$name} module not found.");
            } elseif (app()->make('streams.modules')->install($addon->slug)) {
                $this->info("{$name} module installed.");
            } else {
                $this->error("There was a problem installing {$name} module.");
            }
        }
	}

}
