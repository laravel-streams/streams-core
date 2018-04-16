<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\Traits\Versionable;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Version\Command\SaveVersion;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class HandleVersioning
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HandleVersioning
{

    use DispatchesJobs;

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new HandleVersioning instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {

        /**
         * If we can't save, there are
         * errors, or no model then skip.
         */
        if (
            $this->builder->hasFormErrors()
            || !$this->builder->canSave()
            || !$this->builder->getFormEntry()
            || !$this->builder->versioningEnabled()
        ) {
            return;
        }

        /* @var EntryModel|EloquentModel $entry */
        $entry = $this->builder->getFormEntry();

        /**
         * Now that the model has finished
         * post-processing we can version.
         */
        if (in_array(Versionable::class, class_uses_recursive($entry))) {

            $entry->unguard();

            $this->dispatch(new SaveVersion($entry));

            $entry->reguard();
        }
    }
}
