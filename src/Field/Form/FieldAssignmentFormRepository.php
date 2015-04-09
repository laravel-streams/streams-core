<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Model\EloquentFormRepository;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldAssignmentFormRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldAssignmentFormRepository extends EloquentFormRepository
{

    protected $model;

    protected $fields;

    protected $streams;

    protected $assignments;

    function __construct(
        FieldModel $model,
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams,
        AssignmentRepositoryInterface $assignments
    ) {
        $this->model       = $model;
        $this->fields      = $fields;
        $this->streams     = $streams;
        $this->assignments = $assignments;
    }

    /**
     * Find a field or return a new one.
     *
     * @param $id
     * @return \Anomaly\Streams\Platform\Field\Contract\FieldInterface|static
     */
    public function findOrNew($id)
    {
        $assignment = $this->assignments->find($id);

        if ($assignment) {
            return $assignment->getField();
        }

        return $this->model->newInstance();
    }

    /**
     * Save the field and assignment.
     *
     * @param FormBuilder $builder
     */
    public function save(FormBuilder $builder)
    {
        $values = $builder->getFormValues();

        $stream = $this->streams->findBySlugAndNamespace(
            $builder->getOption('stream'),
            $builder->getOption('namespace')
        );

        $field = $this->fields->create(
            [
                'slug'      => str_slug($values->get('slug'), '_'),
                'name'      => $values->get('name'),
                'type'      => $values->get('type'),
                'namespace' => 'users',
                'locked'    => false
            ]
        );

        $this->assignments->create(
            $stream,
            $field,
            [
                'label'        => $values->get('label'),
                'instructions' => $values->get('instructions'),
                'translatable' => $values->get('translatable', false),
                'required'     => $values->get('required', false),
                'unique'       => $values->get('unique', false)
            ]
        );
    }
}
