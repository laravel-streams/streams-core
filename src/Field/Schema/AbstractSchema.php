<?php

namespace Streams\Core\Field\Schema;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;

class AbstractSchema
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

        $this->format($schema);
        $this->descriptors($schema);
        $this->constraints($schema);

        return $schema;
    }

    public function type()
    {
        return Schema::string($this->field->handle);
    }

    public function format(Schema $schema): void
    {
    }

    public function descriptors(Schema $schema): void
    {
    }

    public function constraints(Schema $schema): void
    {
    }
}
