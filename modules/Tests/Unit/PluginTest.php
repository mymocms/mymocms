<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tests\Unit;

use Juzaweb\CMS\Support\Plugin;
use Juzaweb\Tests\TestCase;

class PluginTest extends TestCase
{
    public function testEnable()
    {
        $plugins = app('plugins')->all();
        foreach ($plugins as $plugin) {
            /**
             * @var Plugin $plugin
             */

            $this->printText("Enable {$plugin->getName()}");

            $plugin->enable();

            $this->assertTrue($plugin->isEnabled());
        }

        $this->assertDatabaseHas(
            'configs',
            ['code' => 'plugin_statuses']
        );

        $this->printText("Check Enable DB");
        $dbPlugins = get_config('plugin_statuses', []);
        $dbPlugins = array_keys($dbPlugins);
        $notEnable = collect(array_keys($plugins))
            ->filter(
                function ($item) use ($dbPlugins) {
                    return !in_array($item, $dbPlugins);
                }
            )
            ->all();

        $this->assertEmpty($notEnable);

        $psr4 = require __DIR__ . '/../../../bootstrap/cache/plugin_autoload_psr4.php';
        $this->printText(json_encode($psr4));
    }

    public function testDisable()
    {
        $plugins = app('plugins')->all();

        foreach ($plugins as $plugin) {
            /**
             * @var Plugin $plugin
             */

            $this->printText("Disable {$plugin->getName()}");

            $plugin->disable();

            $this->assertTrue($plugin->isDisabled());
        }

        $this->printText("Check Enable DB");
        $dbPlugins = get_config('plugin_statuses', []);
        $dbPlugins = array_keys($dbPlugins);
        $this->assertEmpty($dbPlugins);
    }
}
