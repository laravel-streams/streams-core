<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildTableFiltersCommandHandler implements CommandInterface
{
    public function handle($command)
    {
        $ui = $command->getUi();

        $filters = evaluate($ui->getFilters(), [$ui]);

        foreach ($filters as &$filter) {

            $input = $this->makeInput($filter, $ui);

            $filter = compact('input');

        }

        return $filters;
    }

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

    protected function makeSelectInput($filter, $ui)
    {
        $form = app('form');

        $list        = evaluate_key($filter, 'list', [], [$ui]);
        $name        = evaluate_key($filter, 'name', null, [$ui]);
        $placeholder = evaluate_key($filter, 'placeholder', null, [$ui]);

        $selected = null;

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->select($name, $list, $selected, $options);
    }

    protected function makeTextInput($filter, $type, $ui)
    {
        $form = app('form');

        $name        = evaluate_key($filter, 'name', null, [$ui]);
        $placeholder = evaluate_key($filter, 'placeholder', null, [$ui]);

        $value = null;

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->{$type}($name, $value, $options);
    }
}
 