<?php
declare(strict_types=1);

namespace Yireo\DisableServiceWorkerInAdmin\Test\Integration;

use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{
    public function testModuleIsEnabled(): void
    {
        $moduleList = Bootstrap::getObjectManager()->get(ModuleList::class);
        $this->assertInstanceOf(ModuleList::class, $moduleList);
        $this->assertTrue($moduleList->has('Yireo_DisableServiceWorkerInAdmin'));
    }
}
