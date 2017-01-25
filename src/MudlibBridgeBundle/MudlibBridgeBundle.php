<?php

namespace MudlibBridgeBundle;

use stesie\mudlib\Kernel;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MudlibBridgeBundle extends Bundle
{
    public function boot()
    {
        (new Kernel($this->container->get('mudlib_bridge.event_bus')))->boot();
    }
}
