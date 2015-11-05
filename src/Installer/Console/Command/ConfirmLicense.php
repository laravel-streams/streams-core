<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Michelf\Markdown;

/**
 * Class ConfirmLicense
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console\Command
 */
class ConfirmLicense implements SelfHandling
{

    /**
     * The console command.
     *
     * @var Command
     */
    protected $command;

    /**
     * Create a new ConfirmLicense instance.
     *
     * @param Command $command
     */
    function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Handle the command.
     *
     * @param Markdown $markdown
     */
    public function handle(Markdown $markdown)
    {
        $this->command->info(strip_tags($markdown->transform(file_get_contents(base_path('LICENSE.md')))));

        if (!$this->command->confirm('Do you agree to the provided license and terms of service?')) {

            $this->command->error('You must agree to the license and terms of service before continuing.');

            exit;
        }
    }
}
