<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Presenter\UrlPresenter;
use Streams\Core\Field\Schema\UrlSchema;

class UrlFieldType extends Field
{

    protected $__attributes = [
        'rules' => [
            'url',
        ],
    ];

    public function getPresenterName()
    {
        return UrlPresenter::class;
    }

    public function getSchemaName()
    {
        return UrlSchema::class;
    }

    public function generate()
    {
        return $this->generator()->url();
    }
}
