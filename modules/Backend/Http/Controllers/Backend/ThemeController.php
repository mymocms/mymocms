<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Http\Requests\Theme\UpdateRequest;
use Juzaweb\CMS\Contracts\BackendMessageContract;
use Juzaweb\CMS\Facades\CacheGroup;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Support\ArrayPagination;
use Juzaweb\CMS\Support\JuzawebApi;
use Juzaweb\CMS\Version;

class ThemeController extends BackendController
{
    protected JuzawebApi $api;

    public function __construct(JuzawebApi $api)
    {
        $this->api = $api;
    }

    public function index(): View
    {
        $activated = jw_current_theme();
        $currentTheme = ThemeLoader::getThemeInfo($activated);

        return view(
            'cms::backend.theme.index',
            [
                'title' => trans('cms::app.themes'),
                'currentTheme' => $currentTheme,
                'activated' => $activated,
            ]
        );
    }

    public function getDataTheme(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 20);
        $activated = jw_current_theme();
        $paginate = ArrayPagination::make(app('themes')->all(true));
        $paginate->where('name', '!=', $activated);

        $paginate = $paginate->paginate($limit);
        $updates = $this->getDataUpdates($paginate->getCollection());

        $items = new Collection();
        foreach ($paginate->items() as $theme) {
            $theme['update'] = $updates->{$theme['name']}->update ?? false;

            $items->push(
                (object) [
                    'update' => $theme['update'],
                    'name' => $theme['name'],
                    'content' => view(
                        'cms::backend.theme.components.theme_item',
                        ['theme' => (object) $theme]
                    )->render(),
                ]
            );
        }

        $paginate->setCollection($items);

        return response()->json(
            [
                'data' => $paginate->items(),
                'meta' => [
                    'totalPages' => $paginate->lastPage(),
                    'limit' => $paginate->perPage(),
                    'total' => $paginate->total(),
                    'page' => $paginate->currentPage(),
                ]
            ]
        );
    }

    /**
     * @throws \Exception
     */
    public function activate(Request $request): JsonResponse
    {
        $request->validate(
            [
                'theme' => 'required',
            ]
        );

        $name = $request->post('theme');
        if (!$theme = Theme::find($name)) {
            return $this->error(
                [
                    'message' => trans('cms::message.theme_not_found'),
                ]
            );
        }

        DB::beginTransaction();
        try {
            $theme->activate();

            $this->addRequireThemeActive($theme);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'redirect' => route('admin.themes'),
            ]
        );
    }

    public function bulkActions(Request $request): JsonResponse|RedirectResponse
    {
        $action = $request->post('action');
        $ids = $request->post('ids');

        if ($action == 'update') {
            $query = ['themes' => $ids];
            $query = http_build_query($query);

            return $this->success(
                [
                    'window_redirect' => route('admin.update.process', ['theme']).'?'.$query,
                ]
            );
        }

        foreach ($ids as $name) {
            try {
                switch ($action) {
                    case 'delete':
                        Theme::delete($name);
                        break;
                }
            } catch (\Throwable $e) {
                report($e);

                return $this->error(
                    [
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }

        return $this->success(
            [
                'message' => trans('cms::app.successfully'),
                'redirect' => route('admin.plugin'),
            ]
        );
    }

    public function install(): View
    {
        if (!config('juzaweb.theme.enable_upload')) {
            abort(403, 'Access deny.');
        }

        $title = trans('cms::app.install');

        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.themes'),
                'url' => route('admin.themes')
            ]
        );

        return view(
            'cms::backend.theme.install',
            compact('title')
        );
    }

    public function getDataThemeInstall(Request $request, JuzawebApi $api): object|array
    {
        if (!config('juzaweb.theme.enable_upload')) {
            return (object) [];
        }

        $limit = $request->get('limit', 20);
        $page = $request->get('page', 1);
        $except = array_keys(ThemeLoader::all(true));

        return $api->get(
            'themes',
            [
                'limit' => $limit,
                'page' => $page,
                'except' => $except
            ]
        );
    }

    protected function addRequireThemeActive(\Juzaweb\CMS\Support\Theme $theme): void
    {
        app(BackendMessageContract::class)->deleteGroup('require_plugins');

        if ($require = $theme->getPluginRequires()) {
            $plugins = Plugin::all();
            $str = [];
            foreach ($require as $plugin => $ver) {
                if (app('plugins')->has($plugin)) {
                    if (app('plugins')->isEnabled($plugin)) {
                        continue;
                    }
                }

                if (!in_array($plugin, array_keys($plugins))) {
                    $plugins[$plugin] = $plugin;
                }

                $str[] = "<strong>{$plugin}</strong>";
            }

            if ($str) {
                $this->addMessage(
                    'require_plugins',
                    trans(
                        'cms::app.theme_require_plugins',
                        [
                            'plugins' => implode(', ', $str),
                            'link' => route('admin.themes.require-plugins')
                        ]
                    )
                );
            }
        }
    }

    protected function getDataUpdates(Collection $themes): ?object
    {
        if (!config('juzaweb.theme.enable_upload')) {
            return (object) [];
        }

        $key = sha1($themes->toJson());
        CacheGroup::add('theme_update_keys', $key);

        return Cache::remember(
            $key,
            3600,
            function () use ($themes) {
                try {
                    $response = $this->api->post(
                        'themes/versions-available',
                        [
                            'themes' => $themes->map(
                                function ($item) {
                                    return [
                                        'name' => $item['name'],
                                        'current_version' => $item['version'] ?? '1.0',
                                    ];
                                }
                            )->values()->toArray(),
                            'cms_version' => Version::getVersion(),
                        ]
                    );

                    if (empty($response->data)) {
                        return (object) [];
                    }

                    return $response->data;
                } catch (\Exception $e) {
                    return (object) [];
                }
            }
        );
    }
}
