<?php

use Tests\TestCase;
use Illuminate\View\View;
use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;

class ButtonCollectionTest extends TestCase
{
    public function testRender()
    {
        $this->assertTrue($this->buttons()->render() instanceof View);
    }

    /**
     * @param array $attributes
     * @return Button
     */
    protected function buttons(array $attributes = [])
    {
        return new ButtonCollection((new Button(array_merge([
            'tag' => 'a',
        ], $attributes))));
    }
}
