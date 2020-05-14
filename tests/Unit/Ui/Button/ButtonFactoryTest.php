<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;

class ButtonFactoryTest extends TestCase
{
    public function testMake()
    {
        $button = $this->button();

        $this->assertTrue($button instanceof Button);
    }

    /**
     * @param array $parameters
     * @return Button
     */
    protected function button(array $parameters = [])
    {
        return app(ButtonFactory::class)->make($parameters);
    }
}
