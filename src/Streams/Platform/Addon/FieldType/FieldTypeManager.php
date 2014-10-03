<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\AddonManager;

class FieldTypeManager extends AddonManager
{
    /**
     * The folder within addons locations to load field_types from.
     *
     * @var string
     */
    protected $folder = 'field_types';
}
