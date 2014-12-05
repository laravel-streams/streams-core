<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Form\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\FormDataLoaded;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\Section\Contract\SectionInterface;
use Laracasts\Commander\Events\DispatchableTrait;

class MakeFormCommandHandler
{

    use DispatchableTrait;

    public function handle(MakeFormCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->setSectionData($form);
        $this->setActionData($form);
        $this->setButtonData($form);

        $form->raise(new FormDataLoaded($builder));

        $this->dispatchEventsFor($form);

        $form->setContent(view($form->getView(), $form->getData()));
    }

    protected function setSectionData(Form $form)
    {
        $sections = [];

        foreach ($form->getSections() as $section) {

            if ($section instanceof SectionInterface) {

                $sections[] = $section->viewData();
            }
        }

        $form->putData('sections', $sections);
    }

    protected function setActionData(Form $form)
    {
        $actions = [];

        foreach ($form->getActions() as $action) {

            if ($action instanceof ActionInterface) {

                $actions[] = $action->viewData();
            }
        }

        $form->putData('actions', $actions);
    }

    protected function setButtonData(Form $form)
    {
        $buttons = [];

        foreach ($form->getButtons() as $button) {

            if ($button instanceof ButtonInterface) {

                $buttons[] = $button->viewData();
            }
        }

        $form->putData('buttons', $buttons);
    }
}
 