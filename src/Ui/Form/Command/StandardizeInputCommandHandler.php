<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Button\ButtonReader;
use Anomaly\Streams\Platform\Ui\Form\Action\ActionReader;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Anomaly\Streams\Platform\Ui\Form\Exception\IncompatibleModelException;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Section\SectionReader;

class StandardizeInputCommandHandler
{

    protected $actionReader;

    protected $buttonReader;

    protected $sectionReader;

    function __construct(ActionReader $actionReader, ButtonReader $buttonReader, SectionReader $sectionReader)
    {
        $this->actionReader  = $actionReader;
        $this->buttonReader  = $buttonReader;
        $this->sectionReader = $sectionReader;
    }

    public function handle(StandardizeInputCommand $command)
    {
        $builder = $command->getBuilder();

        $this->standardizeModelInput($builder);
        $this->standardizeActionInput($builder);
        $this->standardizeButtonInput($builder);
        $this->standardizeSectionInput($builder);
    }

    protected function standardizeModelInput(FormBuilder $builder)
    {
        $table = $builder->getForm();
        $class = $builder->getModel();

        $model = app($class);

        /**
         * If the model can extract a Stream then
         * set it on the table at this time so we
         * can use it later if we need.
         */
        if ($model instanceof EntryInterface) {

            $table->setStream($model->getStream());
        }

        if (!$model instanceof FormModelInterface) {

            throw new IncompatibleModelException("[$class] must implement Anomaly\\Streams\\Platform\\Ui\\Form\\Contract\\FormModelInterface");
        }

        $builder->setModel($model);
    }

    protected function standardizeActionInput(FormBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as $key => &$action) {

            $action = $this->actionReader->convert($key, $action);
        }

        $builder->setActions(array_values($actions));
    }

    protected function standardizeButtonInput(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            $button = $this->buttonReader->convert($key, $button);
        }

        $builder->setButtons(array_values($buttons));
    }

    protected function standardizeSectionInput(FormBuilder $builder)
    {
        $sections = $builder->getSections();

        foreach ($sections as $key => &$section) {

            $section = $this->sectionReader->convert($key, $section);

            if (isset($section['fields'])) {

                $section['section'] = 'fields';
            }
        }

        $builder->setSections(array_values($sections));
    }
}
 