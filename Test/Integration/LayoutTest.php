<?php
declare(strict_types=1);

namespace Yireo\DisableServiceWorkerInAdmin\Test\Integration;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\Fixture\Config as ConfigFixture;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

#[AppArea('adminhtml')]
class LayoutTest extends TestCase
{
    private const BLOCK_NAME = 'yireo.disable_service_worker';

    public function testBlockIsAddedToAdminLayout(): void
    {
        $layout = $this->getLayout();
        $block = $layout->getBlock(self::BLOCK_NAME);

        $this->assertInstanceOf(Template::class, $block);
        $this->assertSame('Yireo_DisableServiceWorkerInAdmin::script.phtml', $block->getTemplate());
        $this->assertSame('after.body.start', $layout->getParentName(self::BLOCK_NAME));
    }

    public function testBlockRendersScript(): void
    {
        $html = $this->renderBlock();

        $this->assertStringContainsString('<script', $html);
        $this->assertStringContainsString('getRegistrations', $html);
        $this->assertStringContainsString('registration.scope', $html);
        $this->assertStringContainsString('location.reload()', $html);
    }

    #[ConfigFixture('csp/policies/admin/scripts/inline', '0', 'store', 'default')]
    public function testScriptGetsNonceWhenInlineScriptsAreDisabled(): void
    {
        $this->assertMatchesRegularExpression('/<script[^>]+nonce="[^"]+"/', $this->renderBlock());
    }

    private function renderBlock(): string
    {
        $block = $this->getLayout()->getBlock(self::BLOCK_NAME);
        $this->assertInstanceOf(Template::class, $block);

        return $block->toHtml();
    }

    private function getLayout(): LayoutInterface
    {
        $pageFactory = Bootstrap::getObjectManager()->get(PageFactory::class);
        $this->assertInstanceOf(PageFactory::class, $pageFactory);
        $page = $pageFactory->create();
        $page->addDefaultHandle();
        $page->getConfig()->setPageLayout('admin-1column');

        return $page->getLayout();
    }
}
