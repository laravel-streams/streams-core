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

        $filters = [];

        foreach ($ui->getFilters() as $filter) {

            if ($input = $this->makeInput($filter, $ui)) {

                $filters[] = compact('input');

            }

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
        $input = null;

        $type = evaluate_key($filter, 'type', 'text', [$ui]);

        switch ($type) {
            case 'select':
                $input = $this->makeSelectInput($filter, $ui);
                break;

            case 'url':
            case 'text':
            case 'email':
            case 'password':
                $input = $this->makeTextInput($filter, $type, $ui);
                break;

            case 'field':
                break;

            default:
                break;
        }

        return $input;
    }

    /**
     * @param $filter
     * @param $ui
     * @return mixed
     */
    protected function makeSelectInput($filter, $ui)
    {
        $form = app('form');

        $options     = evaluate_key($filter, 'options', [], [$ui]);
        $slug        = evaluate_key($filter, 'slug', null, [$ui]);
        $placeholder = evaluate_key($filter, 'placeholder', null, [$ui]);

        $value = $this->getInput($filter, $slug);

        $attributes = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->select($slug, $options, $value, $attributes);
    }

    /**
     * @param $filter
     * @param $type
     * @param $ui
     * @return mixed
     */
    protected function makeTextInput($filter, $type, $ui)
    {
        $form = app('form');

        $slug        = evaluate_key($filter, 'slug', null, [$ui]);
        $placeholder = evaluate_key($filter, 'placeholder', null, [$ui]);

        $value = $this->getInput($filter, $slug);

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->{$type}($slug, $value, $options);
    }

    protected function getInput($filter, $slug)
    {
        $input = app('request');

        if (isset($_GET[$slug])) {
            $value = $_GET[$slug];
        } else {
            $value = evaluate_key($filter, 'default_value', null);
        }

        return $value;
    }
}
 