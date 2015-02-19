<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class DeleteActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Delete
{

    /**
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * Create a new Delete instance.
     *
     * @param MessageBag $messages
     */
    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Save the order of the entries.
     *
     * @param Table $table
     * @param array $selected
     */
    public function handle(Table $table, array $selected)
    {
        $model = $table->getModel();

        $this->deleteEntries($model, $selected);

        $table->setResponse(redirect(app('request')->fullUrl()));
    }

    /**
     * Delete the entries.
     *
     * @param EloquentModel $model
     * @param array         $selected
     */
    protected function deleteEntries(EloquentModel $model, array $selected)
    {
        foreach ($selected as $id) {
            if ($entry = $model->find($id)) {
                $entry->delete();
            }
        }
    }
}
