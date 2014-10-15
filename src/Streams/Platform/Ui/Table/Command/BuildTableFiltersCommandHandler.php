<?php namespace Streams\Platform\Ui\Table\Command;

class BuildTableFiltersCommandHandler
{
    /**
     * @param $command
     * @return mixed|null
     */
    public function handle(BuildTableFiltersCommand $command)
    {
        $ui = $command->getUi();

        $filters = evaluate($ui->getFilters(), [$ui]);

        foreach ($filters as &$filter) {

            $input = $this->makeInput($filter, $ui);

            $filter = compact('input');

        }

        return $filters;
    }

    /**
     * @param $filter
     * @param $ui
     * @return null
     */
    protected function makeInput($filter, $ui)
    {
        $type = evaluate_key($filter, 'type', 'text', [$ui]);

        switch ($type) {
            case 'select':
                return $this->makeSelectInput($filter, $ui);
                break;

            case 'url':
            case 'text':
            case 'email':
            case 'password':
                return $this->makeTextInput($filter, $type, $ui);
                break;

            default:
                break;
        }

        return null;
    }

    /**
     * @param $filter
     * @param $ui
     * @return mixed
     */
    protected function makeSelectInput($filter, $ui)
    {
        $form  = app('form');
        $input = app('input');

        $list        = evaluate_key($filter, 'list', [], [$ui]);
        $name        = evaluate_key($filter, 'name', null, [$ui]);
        $placeholder = evaluate_key($filter, 'placeholder', null, [$ui]);

        $selected = $input->get($name);

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->select($name, $list, $selected, $options);
    }

    /**
     * @param $filter
     * @param $type
     * @param $ui
     * @return mixed
     */
    protected function makeTextInput($filter, $type, $ui)
    {
        $form  = app('form');
        $input = app('input');

        $name        = evaluate_key($filter, 'name', null, [$ui]);
        $placeholder = evaluate_key($filter, 'placeholder', null, [$ui]);

        $value = $input->get($name);

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->{$type}($name, $value, $options);
    }
}
 