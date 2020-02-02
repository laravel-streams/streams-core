<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class FieldCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldCollection extends EloquentCollection
{

    /**
     * Return field slugs.
     * 
     * @param null $prefix
     * @return FieldCollection
     */
    public function slugs($prefix = null)
    {
        return $this->map(function ($field) use ($prefix) {
            return ($prefix ?: null) . $field->slug;
        });
    }

    /**
     * Return translatable fields.
     * 
     * @return FieldCollection
     */
    public function translatable($translatable = true)
    {
        return $this->filter(function ($field) use ($translatable) {
            return $field->isTranslatable() === $translatable ? $field : null;
        });
    }

    /**
     * Return translatable fields.
     * 
     * @return FieldCollection
     */
    public function dates($translatable = true)
    {
        return $this->filter(function ($field) use ($translatable) {
            return $field->isTranslatable() === $translatable ? $field : null;
        });
    }
}
