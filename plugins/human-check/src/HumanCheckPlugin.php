<?php
declare(strict_types=1);
namespace Beaver\Plugins\HumanCheck;

use Beaver\Plugin\PluginBase;

class HumanCheckPlugin extends PluginBase
{
    public function boot(): void
    {
        $this->loadViews();
        $this->loadRoutes();
    }
}
