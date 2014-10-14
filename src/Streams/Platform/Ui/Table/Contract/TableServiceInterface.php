<?php namespace Streams\Platform\Ui\Table\Contract;

interface TableServiceInterface
{
    public function views();

    public function filters();

    public function headers();

    public function rows();

    public function actions();

    public function pagination();

    public function options();
}
 