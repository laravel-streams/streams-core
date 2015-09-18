<?php namespace Anomaly\Streams\Platform\Stream\Form;

use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class StreamFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Form
 */
class StreamFormBuilder extends FormBuilder
{

    /**
     * The form model.
     *
     * @var StreamModel
     */
    protected $model = StreamModel::class;

}
