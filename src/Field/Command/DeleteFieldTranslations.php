<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class DeleteFieldTranslations
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class DeleteFieldTranslations implements SelfHandling
{

    /**
     * The field instance.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * Create a new DeleteFieldTranslations instance.
     *
     * @param FieldInterface $field
     */
    public function __construct(FieldInterface $field)
    {
        $this->field = $field;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->field->getTranslations() as $translation) {
            $translation->delete();
        }
    }
}
