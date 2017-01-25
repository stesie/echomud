<?php

namespace MudlibBridgeBundle;

use stesie\mudlib\Kernel;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MudlibBridgeBundle extends Bundle
{
    public function boot()
    {
        $this->container->get('mudlib_bridge.kernel')->boot();
    }
}
