<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade as FacadeAlias;
use Juzaweb\CMS\Support\LocalThemeRepository;
use Juzaweb\CMS\Support\Theme as ThemeSupport;

/**
 * @method static ThemeSupport|null find(string $name)
 * @method static void activate(string $name)
 * @method static void delete(string $name)
 * @method static array|Collection all(bool $collection = false)
 *
 * @see LocalThemeRepository
 */
class Theme extends FacadeAlias
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'themes';
    }
}
