<?php

namespace Streams\Core\Field\Schema;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;

class Schema
{
    use Macroable;
    use FiresCallbacks;

    protected FieldType $type;

    public function __construct(FieldType $type)
    {
        $this->type = $type;
    }

    public function create()
    {
        $schema = $this->type();

        $this->fire('creating_schema', compact('schema'));

        $this
            ->format($schema)
            ->constraints($schema);

        $this->fire('created_schema', compact('schema'));

        return $schema;
    }

    public function type()
    {
        return Schema::string($this->field->handle);
    }

    public function format(Schema $schema): self
    {
        return $this;
    }

    public function constraints(Schema $schema): self
    {
        return $this;
    }
}
