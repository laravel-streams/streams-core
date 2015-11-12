<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class DeleteTranslations
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class DeleteTranslations implements SelfHandling
{

    /**
     * The entry instance.
     *
     * @var EntryInterface
     */
    protected $entry;

    /**
     * Create a new DeleteTranslations instance.
     *
     * @param EntryInterface $entry
     */
    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        if ($this->entry->isTranslatable()) {
            foreach ($this->entry->getTranslations() as $translation) {
                $translation->delete();
            }
        }
    }
}
