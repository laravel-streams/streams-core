<?php namespace Streams\Platform\Addon\Block;

use Streams\Platform\Addon\Addon;
use Streams\Platform\Contract\PresentableInterface;

class BlockAddon extends Addon implements PresentableInterface
{
    protected $type = 'block';

    public function newPresenter()
    {
        return new BlockPresenter($this);
    }
}
