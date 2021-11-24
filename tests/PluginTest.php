<?php

namespace AfOrderAttributes\Tests;

use AfOrderAttributes\AfOrderAttributes as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'AfOrderAttributes' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['AfOrderAttributes'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
