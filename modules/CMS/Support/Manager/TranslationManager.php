<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Manager;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Contracts\TranslationFinder;
use Juzaweb\CMS\Contracts\TranslationManager as TranslationManagerContract;
use Spatie\TranslationLoader\LanguageLine;

class TranslationManager implements TranslationManagerContract
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository,
        protected LocalThemeRepositoryContract $themeRepository,
        protected TranslationFinder $translationFinder
    ) {
    }

    public function import(string $module, string $name = null): int
    {
        $module = $this->find($module, $name);
        $locales = $this->getLocalLocales($module, $name);

        $total = 0;
        foreach ($locales as $locale) {
            $result = $this->getLocalTranslates($module, $name, $locale['code']);
            foreach ($result as $item) {
                $model = $this->importLanguageLine(
                    array_merge(
                        $item,
                        [
                            'namespace' => $module->get('namespace'),
                            'locale' => $locale['code'],
                        ]
                    )
                );

                if ($model->wasRecentlyCreated) {
                    $total += 1;
                }
            }
        }

        /* Import missing key */
        $result = $this->translationFinder->find(
            $module->get('src_path')
        );

        foreach ($result as $item) {
            $model = $this->importLanguageLine($item);

            if ($model->wasRecentlyCreated) {
                $total += 1;
            }
        }

        return $total;
    }

    public function export(string $module = 'cms', string $name = null)
    {
        //
    }

    public function translate(string $source, string $target, string $module = 'cms', string $name = null)
    {
        //
    }

    public function find(string|Collection $module, string $name = null): Collection
    {
        if ($module instanceof Collection) {
            return $module;
        }

        switch ($module) {
            case 'plugin':
                $plugin = $this->pluginRepository->find($name);
                return new Collection(
                    [
                        'title' => $plugin->getDisplayName(),
                        'name' => $plugin->get('name'),
                        'namespace' => $plugin->getDomainName(),
                        'type' => 'plugin',
                        'lang_path' => $plugin->getPath('src/resources/lang'),
                        'src_path' => $plugin->getPath('src'),
                    ]
                );
            case 'theme':
                $theme = $this->themeRepository->find($name);
                return new Collection(
                    [
                        'title' => $theme->get('title'),
                        'name' => $theme->get('name'),
                        'namespace' => '*',
                        'type' => 'theme',
                        'lang_path' => $theme->getPath('lang'),
                        'src_path' => $theme->getPath('views'),
                    ]
                );
            default:
                return new Collection(
                    [
                        'title' => 'CMS',
                        'namespace' => 'cms',
                        'type' => 'cms',
                        'lang_path' => base_path('modules/Backend/resources/lang'),
                        'view_path' => base_path('modules'),
                    ]
                );
        }
    }

    protected function getLocalLocales(string|Collection $module = 'cms', string $name = null): array
    {
        $folderPath = $this->find($module, $name)->get('lang_path');
        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = collect(File::directories($folderPath))
            ->map(fn ($item) => basename($item))
            ->values()
            ->toArray();

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    /**
     * Get all language trans
     *
     * @param string|Collection $module
     * @param string|null $name
     * @param string $locale
     * @return array
     */
    protected function getLocalTranslates(
        string|Collection $module = 'cms',
        string $name = null,
        string $locale = 'en'
    ): array {
        $files = File::files($this->find($module, $name)->get('lang_path') . "/{$locale}");
        $files = collect($files)
            ->filter(fn ($item) => $item->getExtension() == 'php')
            ->values()
            ->toArray();

        $result = [];
        foreach ($files as $file) {
            $lang = require($file->getRealPath());
            $group = str_replace('.php', '', $file->getFilename());
            $this->mapGroupKeys($lang, $group, $result);
        }

        return $result;
    }

    protected function mapGroupKeys(array $lang, $group, &$result, $keyPrefix = '')
    {
        foreach ($lang as $key => $item) {
            if (is_array($item)) {
                $prefix = "{$keyPrefix}{$key}.";
                $this->mapGroupKeys($item, $group, $result, $prefix);
            } else {
                $result[] = [
                    'key' => $keyPrefix . $key,
                    'value' => $item,
                    'group' => $group
                ];
            }
        }
    }

    private function importLanguageLine(array $data): LanguageLine
    {
        $locale = trim($data['locale']);

        $model = LanguageLine::firstOrNew(
            [
                'group' => $data['group'],
                'namespace' => $data['namespace'],
                'key' => $data['key'],
            ]
        );

        if (!isset($model->text[$locale])) {
            $model->setTranslation($locale, $data['value']);
            $model->save();
        }

        return $model;
    }
}
