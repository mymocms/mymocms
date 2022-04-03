<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Movie\Providers;

use Juzaweb\Support\ServiceProvider;

class AutoloadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $viewPath = __DIR__ .'/../resources/views';
        $langPath = __DIR__ . '/../resources/lang';
    
        $domain = 'mymo';
        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, $domain);
        }
    
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $domain);
        }
    }
}