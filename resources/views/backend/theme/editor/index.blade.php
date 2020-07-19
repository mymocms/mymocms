<!doctype html>
<html class="no-js">
<head>
    <link rel="shortcut icon" href="{{ asset('styles/images/brand/favicon.ico') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ trans('app.customize_theme') }}</title>
    <meta name="description" content="{{ trans('app.customize_theme') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link rel="stylesheet" href="{{ asset('css/theme-editor.css') }}">
    <!--[if lt IE 9]>
    <script src="{{ asset('styles/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('styles/js/respond.min.js') }}"></script>
    <![endif]-->

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/theme-editor.js') }}"></script>

    <script type="text/javascript">
        $(document).ajaxStart(function () {
            Juzaweb.Loading.start();
        });
        $(document).ajaxComplete(function () {
            Juzaweb.Loading.stop();
        });

        setInterval(function () {
            Juzaweb.CSRFToken.update();
        }, 3600000);
    </script>
</head>
<body class="body-theme-editor theme-editor sfe-next fresh-ui next-ui" id="theme-editor" style="height: 100% !important;">
<div class="ui-flash-container">
    <div class="ui-flash-wrapper" id="UIFlashWrapper">
        <div class="ui-flash ui-flash--nav-offset" id="UIFlashMessage"><p class="ui-flash__message"></p><div class='ui-flash__close-button'><button class='ui-button ui-button--transparent ui-button--icon-only ui-button-flash-close' aria-label='Close message' type='button' name='button'><svg class='next-icon next-icon--color-white next-icon--size-12'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#next-remove'><svg id='next-remove' width='100%' height='100%'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><path d='M18.263 16l10.07-10.07c.625-.625.625-1.636 0-2.26s-1.638-.627-2.263 0L16 13.737 5.933 3.667c-.626-.624-1.637-.624-2.262 0s-.624 1.64 0 2.264L13.74 16 3.67 26.07c-.626.625-.626 1.636 0 2.26.312.313.722.47 1.13.47s.82-.157 1.132-.47l10.07-10.068 10.068 10.07c.312.31.722.468 1.13.468s.82-.157 1.132-.47c.626-.625.626-1.636 0-2.26L18.262 16z'></path></svg></svg></use></svg></button></div>
        </div>
    </div>
</div>

<main class="theme-editor__wrapper" component="UI.Progress" define="{editorThemeV2: new Juzaweb.ThemeSettingsV2(this,{&quot;current_section&quot;:-1,&quot;id&quot;:731236})}" context="editorThemeV2">
    <div class="notifications"><div class="ajax-notification"><span class="ajax-notification-message"></span><a class="close-notification" onclick="Juzaweb.Flash.hide()"><i class="fa fa-times"></i></a></div></div>
    <script type="text/javascript">
        Page(function () {
            $(document).on("click", Juzaweb.SingleDropdown.checkFocus);
            document.addEventListener('page:before-replace', function () {
                $(document).off("click", Juzaweb.SingleDropdown.checkFocus);
            }, { once: true });
        });
    </script>

    <div id="theme-editor-sidebar">

        <section class="theme-editor__index" component="UI.PanelContainer">
                <header class="te-top-bar">
                    {{--<div class="te-top-bar__branding">
                        <a title="{{ trans('app.theme') }}" aria_label="{{ trans('app.theme') }}" class="te-brand-link" data-no-turbolink="true" href="{{ route('vendor.admin.menu') }}">
                            <span class="te-brand-logo" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 42">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#logo-sapo"></use>
                            </span>
                        </a>
                    </div>--}}
                    <div class="te-top-bar__list">
                        <div class="te-top-bar__item te-top-bar__item--fill">
                            <span class="te-theme-name"><a href="{{ route('admin.theme.themes') }}" data-no-turbolink="true">‹‹ {{ trans('app.back_to') }} {{ trans('app.theme') }}</a></span>
                        </div>
                        <div class="te-top-bar__item te-status-indicator--live mobile-only">
                            Live
                        </div>
                    </div>
                </header>

                <div class="theme-editor__panel-body">
                    <div class="ui-stack ui-stack--vertical next-tab__panel--grow">
                        <div class="ui-stack-item ui-stack-item--fill">
                            <section class="next-card theme-editor__card">
                                <ul class="theme-editor-action-list theme-editor-action-list--divided theme-editor-action-list--rounded">
                                @foreach($config as $index => $item)
                                    <li title="{{ $item['name'] }}">
                                        <button class="btn theme-editor-action-list__item" data-bind-event-click="openSection({{ $index }})" type="button" name="button">
                                            <div class="ui-stack ui-stack--alignment-center ui-stack--spacing-none">
                                                <div class="ui-stack-item stacked-menu__item-icon stacked-menu__item-icon--small">
                                                    <div class="theme-editor__icon">
                                                        <svg class="next-icon next-icon--color-slate-lighter next-icon--size-24"> <use xlink:href="#settings" /> </svg>
                                                    </div>
                                                </div>
                                                <div class="ui-stack-item ui-stack-item--fill stacked-menu__item-text">
                                                    {{ $item['name'] }}
                                                </div>
                                            </div>
                                        </button>
                                    </li>
                                @endforeach
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>

                @foreach($config as $index => $item)
                    @php
                    $options = json_decode(theme_config($item['code']), true);
                    @endphp
                <div class="theme-editor__panel" id="panel-{{ $index }}" tabindex="-1">
                    <header class="te-panel__header">
                        <button class="ui-button btn--plain te-panel__header-action" data-bind-event-click="closeSection()" data-trekkie-id="close-panel" aria-label="Back to theme settings" type="button" name="button">
                            <svg class="next-icon next-icon--size-20 next-icon--rotate-180 te-panel__header-action-icon">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-chevron"></use>
                            </svg>
                        </button>
                        <h2 class="ui-heading theme-editor__heading">{{ $item['name'] }}</h2>

                    </header>

                    <div class="theme-editor__panel-body" data-scrollable>
                        <form action="{{ route('admin.theme.editor.save') }}" method="post" class="form-ajax" data-success="save_success">
                            <button class="btn btn-save-top" type="submit">{{ trans('app.save') }}</button>

                            <input type="hidden" name="code" value="{{ $item['code'] }}">

                        @if(isset($item['cards']))
                        @foreach($item['cards'] as $icard => $card)
                            @php
                                $option_card = @$options[$card['code']];
                            @endphp
                        <section class="next-card theme-editor__card card-{{ $index }}-{{ $icard }}">
                            <section class="next-card__section">

                                <header class="next-card__header theme-setting theme-setting--header">
                                    <h3 class="ui-subheading">{{ $card['name'] }} <a href="javascript:void(0)" class="show-card-body"><i class="fa fa-eye"></i> {{ trans('app.show') }}</a></h3>
                                </header>

                                <div class="card-body">
                                    <input type="hidden" name="{{ $card['code'] }}[code]" value="{{ $card['code'] }}">

                                    @if(isset($card['status']))

                                        <div class="theme-setting theme-setting--text editor-item">
                                            <div class="next-input-wrapper">
                                                <div class="checkbox" id="setting-checkbox-favicon_enable">
                                                    <label class="next-label next-label--switch">
                                                        {{ trans('app.enable') }}
                                                    </label>
                                                    <input type="checkbox" class="next-checkbox check-status" {{ (isset($option_card['status']) && (int) $option_card['status'] == 1) ? 'checked' : '' }}>
                                                    <input type="hidden" name="{{ $card['code'] }}[status]" class="check-status-hide" value="{{ isset($option_card['status']) ? (int) $option_card['status'] : 0 }}">
                                                    <span class="next-checkbox--styled">
                                                        <svg class="next-icon next-icon--size-10 checkmark">
                                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-checkmark-thick"></use>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                @if(isset($card['input_items']))
                                    @foreach($card['input_items'] as $iinput => $input)
                                    @if(in_array($input['element'], ['input', 'textarea', 'media', 'slider', 'select_category']))

                                            @include('backend.theme.editor.input_box')

                                        @else
                                            @include('backend.theme.editor.'. $input['element'] .'_box')
                                        @endif

                                    @endforeach
                                @endif


                                </div>
                            </section>
                        </section>
                        @endforeach
                        @endif

                            <button class="btn btn--full-width" type="submit">{{ trans('app.save') }}</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </section>
    </div>
    <style>
        #myProgress {
            width: 100%;
            background-color: #ddd;
            margin: 10px 0;
        }

        #myBar {
            width: 1%;
            height: 12px;
            background-color: #3498DB;
            border-radius: 3px;
        }

        .action-setting-themes .btn {
            padding: 9px 14px;
        }
    </style>

    <section class="theme-editor__preview te-preview__container" component="UI.Preview">
        <header class="te-context-bar">
            <div class="te-top-bar__branding desktop-only hide" bind-show="">
                <a title="Navigate to themes" aria_label="Navigate to themes" class="te-brand-link" data-no-turbolink="true" href="/admin/themes">
                    <svg class="ui-inline-svg te-brand-logo" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 42">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#logo-sapo"></use>
                    </svg>
                </a>
            </div>
            <div class="te-top-bar__list te-preview-context-bar__inner" data-bind-class="">
                <div class="te-top-bar__item te-top-bar__item--fill te-top-bar__item--bleed">
                    <ul class="segmented te-top-bar__button te-viewport-selector desktop-only">
                        <li>
                            <button class="ui-button ui-button--transparent ui-button--icon-only" bind-event-click="changeThemePreviewMode(this)"
                                    data-bind-class="{'is-selected': viewportSize == 'mobile'}" data-preview="mobile" data-trekkie-id="mobile" aria-label="Small screen" type="button" name="button">
                                <svg class="next-icon next-icon--size-16 next-icon--flip-horizontal">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#phone"></use>
                                </svg>
                            </button>
                        </li>
                        <li>
                            <button class="ui-button ui-button--transparent ui-button--icon-only is-selected" bind-event-click="changeThemePreviewMode(this)"
                                    data-bind-class="{'is-selected': viewportSize == 'desktop'}" data-preview="desktop" data-trekkie-id="desktop" aria-label="Large screen" type="button" name="button">
                                <svg class="next-icon next-icon--size-16">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#desktop"></use>
                                </svg>
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="te-top-bar__item te-status-indicator--live desktop-only">
                    Live
                </div>


            </div>
        </header>
        <label class="helper--visually-hidden" for="theme-editor__iframe-wrapper" id="theme-editor__iframe-label">
            <h1>{{ trans('app.preview') }}</h1>
            <p>
                Press Enter to navigate. Click Escape to return to the Edit page.
            </p>
        </label>
        <div class="theme-editor__iframe-wrapper"
             data-bind-class=""
             tabindex="0"
             aria-labelledby="theme-editor__iframe-label" data-preview-window="desktop">
            <iframe id="theme-editor-iframe" class="theme-editor__iframe" scrolling="yes" sandbox="allow-same-origin allow-forms allow-popups allow-scripts allow-modals" tabindex="-1" src="{{ route('home') }}">
            </iframe>
        </div>
    </section>

    <div class="theme-editor__spinner" component="UI.Spinner">
        <div class="next-spinner">
            <svg class="next-icon next-icon--size-24"> <use xlink:href="#next-spinner" /> </svg>
        </div>
    </div>

</main>

<div id="global-icon-symbols" data-tg-refresh="global-icon-symbols" data-tg-refresh-always="true" style="display: none;">
    <svg xmlns="http://www.w3.org/2000/svg">
        <symbol id="next-ellipsis"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="2.769" cy="12" r="2.769" /><circle cx="12" cy="12" r="2.769" /><circle cx="21.231" cy="12" r="2.769" /></svg></symbol>
        <symbol id="color"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M18.597 10.177l1.228 1.227 7.62-6.585c.34-.295.538-.705.554-1.156.016-.45-.15-.874-.47-1.193-.318-.317-.728-.488-1.192-.467-.45.016-.86.213-1.155.554l-6.586 7.62zm1.178 3.592c-.257 0-.513-.1-.707-.294l-2.542-2.542c-.37-.37-.393-.965-.05-1.36l7.193-8.325c.653-.756 1.6-1.21 2.596-1.246.987-.047 1.973.348 2.68 1.053.704.706 1.09 1.683 1.05 2.68-.035.997-.488 1.943-1.243 2.595l-8.324 7.194c-.19.162-.423.243-.655.243z" /><path d="M10.555 10.397l9.05 9.05 2.696-2.698-9.048-9.05-2.697 2.697zm9.05 11.463c-.257 0-.513-.098-.708-.293L8.434 11.104c-.39-.39-.39-1.023 0-1.414l4.11-4.11c.392-.392 1.025-.392 1.415 0L24.42 16.04c.39.39.39 1.023 0 1.414l-4.11 4.11c-.196.196-.452.294-.708.294z" /><path d="M21.66 19.305c-.13 0-.257-.05-.355-.146L10.843 8.695c-.196-.196-.196-.512 0-.707.195-.197.51-.197.707 0l10.463 10.46c.195.197.195.513 0 .71-.098.096-.226.145-.354.145M9.38 26.561l1.025 1.027 7.256-7.255-7.99-7.992-7.256 7.256 4.006 4.006 2.383-.415c.336-.056.68.06.907.31.23.252.317.602.23.93l-.56 2.135zm1.025 3.442c-.255 0-.51-.098-.707-.293l-2.14-2.14c-.25-.253-.35-.62-.26-.962l.312-1.183-1.36.236c-.32.055-.647-.046-.877-.276l-5.08-5.08C.106 20.116 0 19.861 0 19.596c0-.266.106-.52.293-.708l8.67-8.67c.39-.39 1.023-.39 1.414 0l9.405 9.404c.188.187.293.442.293.707 0 .267-.105.52-.293.71l-8.67 8.668c-.195.196-.45.294-.707.294z" /><path d="M8.974 24.673c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l4.21-4.21c.195-.195.51-.195.706 0 .196.195.196.512 0 .707l-4.208 4.21c-.098.097-.226.146-.354.146M5.33 24.276c-.13 0-.257-.05-.355-.146-.195-.196-.195-.512 0-.708l3.766-3.766c.196-.195.513-.195.708 0 .195.196.195.512 0 .707L5.683 24.13c-.098.097-.226.146-.354.146M3.646 22.058c-.128 0-.256-.05-.354-.146-.196-.196-.196-.512 0-.708l6.32-6.32c.194-.194.51-.194.707 0 .194.196.194.513-.002.708L4 21.912c-.1.097-.227.146-.354.146" /></g></svg></symbol>
        <symbol id="typography"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M24.977 26.84c-.553 0-1-.447-1-1V4.293c0-.552.447-1 1-1 .553 0 1 .448 1 1v21.55c0 .55-.447 1-1 1z" /><path d="M28.977 29.906c-1.614 0-3.08-.794-4-1.997-.92 1.202-2.386 1.996-4 1.996-.553 0-1-.448-1-1s.447-1 1-1c1.626 0 3-1.324 3-2.892 0-.552.447-1 1-1 .553 0 1 .448 1 1 0 1.568 1.374 2.892 3 2.892.553 0 1 .448 1 1s-.447 1-1 1M24.977 5.892c-.553 0-1-.448-1-1 0-1.567-1.374-2.892-3-2.892-.553 0-1-.447-1-1 0-.552.447-1 1-1 1.614 0 3.08.795 4 1.997.92-1.202 2.386-1.997 4-1.997.553 0 1 .448 1 1 0 .553-.447 1-1 1-1.626 0-3 1.325-3 2.892 0 .552-.447 1-1 1" /><path d="M20.977 22.422h8" /><path d="M20.977 22.922h8v-1h-8M8.977 24.906h2v-15c0-.552.447-1 1-1h6v-2H2v2h5.977c.553 0 1 .448 1 1v15zm3 2h-4c-.553 0-1-.448-1-1v-15H1c-.552 0-1-.448-1-1v-4c0-.552.448-1 1-1h17.977c.553 0 1 .448 1 1v4c0 .552-.447 1-1 1h-6v15c0 .552-.447 1-1 1z" /></g></svg></symbol>
        <symbol id="header"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M26.938 30.02H2.958c-.55 0-1-.447-1-1V11c0-.552.45-1 1-1 .553 0 1 .448 1 1v17.02h21.98V11c0-.552.448-1 1-1s1 .448 1 1v18.02c0 .553-.448 1-1 1z" /><path d="M2 10h26V2H2v8zm27 2H1c-.552 0-1-.448-1-1V1c0-.552.448-1 1-1h28c.552 0 1 .448 1 1v10c0 .552-.448 1-1 1z" /><path d="M22.76 11.417c-.128 0-.256-.05-.354-.146-.195-.195-.195-.51 0-.707l6.24-6.24c.196-.196.512-.196.708 0 .195.195.195.51 0 .707l-6.24 6.24c-.098.098-.226.147-.354.147M6.58 11.923c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.91-9.91c.195-.195.512-.195.707 0 .195.195.195.512 0 .707l-9.91 9.91c-.097.097-.225.146-.353.146M13.167 10.56c-.128 0-.256-.048-.354-.145-.195-.196-.195-.512 0-.708L21.58.943c.194-.195.51-.195.706 0 .195.195.195.512 0 .707l-8.765 8.765c-.097.097-.225.146-.353.146M17.792 11.16c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.146-9.146c.196-.195.512-.195.708 0 .195.195.195.512 0 .707l-9.146 9.147c-.098.097-.226.146-.354.146M1.862 11.417c-.128 0-.256-.05-.354-.146-.195-.195-.195-.51 0-.707l8.988-8.987c.196-.196.512-.196.707 0 .196.195.196.51 0 .707L2.216 11.27c-.098.098-.226.147-.354.147M1 7.007c-.128 0-.256-.05-.354-.146-.195-.195-.195-.51 0-.707L5.858.943c.195-.196.512-.196.707 0 .195.195.195.51 0 .707l-5.21 5.21c-.1.098-.227.147-.355.147" /></g></svg></symbol>
        <symbol id="footer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M26.938 20.02c-.552 0-1-.447-1-1V2H3.958v17.02c0 .553-.447 1-1 1-.55 0-1-.447-1-1V1c0-.552.45-1 1-1h23.98c.552 0 1 .448 1 1v18.02c0 .553-.448 1-1 1z" /><path d="M2 28.02h26v-8H2v8zm27 2H1c-.552 0-1-.447-1-1v-10c0-.55.448-1 1-1h28c.552 0 1 .45 1 1v10c0 .553-.448 1-1 1z" /><path d="M22.76 29.438c-.128 0-.256-.05-.354-.146-.195-.197-.195-.513 0-.71l6.24-6.24c.196-.194.512-.194.708.002.195.194.195.51 0 .706l-6.24 6.24c-.098.1-.226.148-.354.148M7.343 29.18c-.128 0-.256-.048-.354-.145-.196-.196-.196-.512 0-.708l9.145-9.146c.196-.194.512-.194.708 0 .195.197.195.513 0 .71l-9.146 9.145c-.098.097-.226.146-.354.146M13.167 28.581c-.128.002-.256-.047-.354-.144-.195-.197-.195-.512 0-.71l8.766-8.764c.194-.195.51-.195.706 0 .195.197.195.512 0 .707l-8.765 8.765c-.097.098-.225.146-.353.146M17.792 29.18c-.128 0-.256-.048-.354-.145-.195-.196-.195-.512 0-.708l9.146-9.146c.196-.194.512-.194.708 0 .195.197.195.513 0 .71l-9.146 9.145c-.098.097-.226.146-.354.146M1.862 29.438c-.128 0-.256-.05-.354-.146-.195-.197-.195-.513 0-.71l8.988-8.986c.196-.195.512-.195.707 0 .196.195.196.512 0 .707l-8.987 8.988c-.098.1-.226.148-.354.148M1 25.027c-.128 0-.256-.05-.354-.146-.195-.195-.195-.51 0-.707l5.212-5.21c.195-.196.512-.196.707 0 .195.195.195.51 0 .707l-5.21 5.21c-.1.098-.227.147-.355.147" /></g></svg></symbol>
        <symbol id="home"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M28 30.055H2c-.553 0-1-.447-1-1V18c0-.552.447-1 1-1 .553 0 1 .448 1 1v10.055h24V18c0-.552.447-1 1-1 .553 0 1 .448 1 1v11.055c0 .553-.447 1-1 1z" /><path d="M29 19h-2c-.304 0-.59-.138-.78-.375L19 9.6l-7.22 9.025c-.19.237-.476.375-.78.375H1c-.553 0-1-.447-1-1V5c0-.553.447-1 1-1h4.507c.553 0 1 .447 1 1 0 .553-.447 1-1 1H2v11h8.52l7.7-9.625c.38-.475 1.18-.475 1.56 0L27.48 17H28V6H11.06c-.552 0-1-.447-1-1 0-.553.448-1 1-1H29c.553 0 1 .447 1 1v13c0 .553-.447 1-1 1" /><path d="M7 2v9.238l3-3.6V2H7zM6 15c-.114 0-.23-.02-.34-.06-.396-.143-.66-.52-.66-.94V1c0-.553.447-1 1-1h5c.553 0 1 .447 1 1v7c0 .234-.082.46-.23.64l-5 6c-.196.233-.48.36-.77.36zM6.95 25.055H10v-3.178H6.95v3.178zm3.55 1H6.45c-.277 0-.5-.224-.5-.5v-4.178c0-.276.223-.5.5-.5h4.05c.276 0 .5.224.5.5v4.178c0 .276-.224.5-.5.5zM22 29.5c-.276 0-.5-.224-.5-.5v-8.004c0-1.376-1.12-2.496-2.497-2.496-1.376 0-2.496 1.12-2.496 2.496V29c0 .276-.224.5-.5.5-.277 0-.5-.224-.5-.5v-8.004c0-1.928 1.568-3.496 3.496-3.496 1.93 0 3.497 1.568 3.497 3.496V29c0 .276-.224.5-.5.5" /></g></svg></symbol>
        <symbol id="product"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M2.414 17.504l10.09 10.09 12.762-12.76-1.056-9.035-9.034-1.057-12.762 12.76zm10.09 12.504c-.255 0-.51-.098-.706-.293L.293 18.21C.105 18.025 0 17.77 0 17.505c0-.265.105-.52.293-.707l13.81-13.81c.216-.216.513-.323.824-.287l10.3 1.204c.46.054.824.417.877.877l1.205 10.302c.034.303-.072.607-.288.823l-13.81 13.81c-.195.195-.45.293-.707.293z" /><path d="M16.902 25.11c-.128 0-.256-.05-.354-.146L5.045 13.46c-.196-.196-.196-.513 0-.708.195-.195.51-.195.707 0l11.504 11.504c.195.196.195.512 0 .708-.098.097-.226.146-.354.146M20.125 8.78c-.295 0-.572.114-.78.322-.43.43-.43 1.132 0 1.562.417.417 1.144.417 1.56 0 .21-.208.324-.486.324-.78 0-.295-.116-.573-.325-.782-.208-.208-.485-.323-.78-.323m0 3.207c-.562 0-1.09-.218-1.488-.616-.82-.82-.82-2.154 0-2.975.795-.794 2.18-.795 2.975 0 .398.398.617.926.617 1.488 0 .563-.22 1.09-.618 1.488-.397.4-.925.617-1.487.617" /><path d="M20.912 8.985c-.084 0-.168-.02-.245-.064-.24-.135-.326-.44-.19-.68l3.805-6.76C24.826.57 25.812.007 26.86 0H27.006c.8 0 1.555.31 2.124.878.574.57.888 1.33.887 2.138 0 1.042-.554 2.026-1.444 2.568l-2.7 1.645c-.235.14-.544.067-.687-.168-.143-.236-.07-.544.167-.688l2.7-1.644c.593-.362.963-1.02.964-1.715 0-.54-.21-1.048-.59-1.43-.38-.377-.885-.585-1.42-.585H26.864c-.7.004-1.36.38-1.718.982l-3.8 6.748c-.09.163-.26.255-.435.255" /></g></svg></symbol>
        <symbol id="collection"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M7.4 17.782l9.047 9.057 11.506-11.523-.946-8.11-8.1-.947L7.402 17.783zm9.047 11.47c-.255 0-.51-.096-.706-.292L5.285 18.49c-.188-.188-.293-.443-.293-.708 0-.265.106-.52.294-.707l12.554-12.57c.216-.216.513-.323.822-.286l9.363 1.093c.46.054.823.417.876.877l1.093 9.377c.035.303-.07.607-.286.823L17.153 28.96c-.195.196-.45.293-.706.293z" /><path d="M19.97 25.753c-.127 0-.255-.05-.352-.145L9.26 15.236c-.194-.195-.194-.51 0-.707.196-.196.512-.196.707 0L20.324 24.9c.195.196.195.512 0 .708-.097.096-.225.145-.353.145" /><path d="M11.453 29.253c-.256 0-.51-.098-.706-.293L.292 18.492C.105 18.305 0 18.05 0 17.785c0-.265.105-.518.292-.707L12.087 5.27c.216-.216.52-.32.82-.286l4.285.498c.548.063.94.56.877 1.11-.067.548-.553.95-1.11.877l-3.803-.445L2.41 17.785l9.043 9.053 1.544-1.546c.39-.392 1.022-.392 1.412 0 .39.39.39 1.023 0 1.413l-2.25 2.253c-.197.195-.45.293-.708.293m11.406-18.897c-.242 0-.484.092-.668.276-.18.18-.277.415-.277.67 0 .25.098.49.277.667.357.357.98.357 1.336 0 .18-.18.277-.417.277-.67 0-.252-.098-.49-.277-.67-.184-.183-.426-.275-.668-.275m0 2.892c-.52 0-1.008-.203-1.374-.57-.368-.368-.57-.857-.57-1.376 0-.52.202-1.01.57-1.378.733-.735 2.015-.735 2.748 0 .368.368.57.857.57 1.377 0 .518-.202 1.007-.57 1.375-.366.367-.855.57-1.374.57" /><path d="M23.93 10.827c-.127 0-.255-.05-.352-.146-.195-.194-.195-.51 0-.706l4.848-4.854c.718-.72.718-1.89 0-2.608-.696-.695-1.906-.697-2.603 0l-3.177 3.18c-.196.197-.512.197-.707 0-.197-.194-.197-.51 0-.706l3.176-3.18C26.19.73 28.06.73 29.132 1.806c1.107 1.106 1.107 2.91 0 4.02l-4.848 4.854c-.097.098-.225.147-.353.147" /></g></svg></symbol>
        <symbol id="settings"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M6 19.236H4V5.966c0-.128.024-.255.072-.375l2-4.964C6.225.248 6.592 0 7 0c.41 0 .776.25.93.63l2.016 5.04c.047.12.072.245.072.372v8.398h-2V6.234l-1.02-2.55L6 6.16v13.076z" /><path d="M5.083 8.068h3.652v-1H5.083M8.028 19.192l-1.832-.803 3.048-6.96c.624-1.426 2.29-2.083 3.72-1.456.692.3 1.224.855 1.5 1.558.276.703.26 1.473-.042 2.165l-1.32 3.01-1.83-.802 1.318-3.01c.088-.203.092-.428.01-.634-.08-.204-.234-.365-.435-.453-.415-.18-.907.007-1.09.425l-3.047 6.96zM14.398 6.364l.23.1.883-.443.494-2.188-.596-.26-1.28 1.847.27.944zm.26 2.203c-.137 0-.273-.027-.4-.083l-1.09-.474c-.275-.12-.482-.356-.564-.643l-.53-1.855c-.08-.288-.03-.597.14-.843l2.018-2.913c.274-.393.785-.537 1.223-.347l2.107.92c.44.19.68.668.575 1.136l-.78 3.458c-.065.293-.26.54-.527.674l-1.726.864c-.14.07-.294.105-.447.105z" /><path d="M13.024 11.092l-.916-.4 1.558-3.557.916.4M9.477 19.858l-1.25-1.56 10.246-8.21v-.012c0-1.88 1.188-3.584 2.955-4.238.11-.04.23-.062.347-.062h2.434c.12 0 .238.02.35.063 1.757.656 2.938 2.358 2.938 4.236 0 2.49-2.022 4.517-4.506 4.517-.34 0-.667-.036-.98-.108l-6.687 5.36-1.25-1.56 7.098-5.69c.28-.226.66-.284.996-.15.244.1.52.148.822.148 1.38 0 2.506-1.13 2.506-2.517 0-.992-.59-1.896-1.485-2.3H21.97c-.902.402-1.497 1.307-1.497 2.3 0 .1.008.203.024.297.06.357-.08.718-.362.945l-10.658 8.54z" /><path d="M5.956 20.063C3.774 20.063 2 21.837 2 24.018c0 2.18 1.774 3.956 3.956 3.956h18.088c2.182 0 3.956-1.775 3.956-3.957 0-2.183-1.774-3.957-3.956-3.957H5.956zm18.088 9.913H5.956C2.672 29.976 0 27.303 0 24.018c0-3.285 2.672-5.957 5.956-5.957h18.088c3.284 0 5.956 2.672 5.956 5.956 0 3.284-2.672 5.956-5.956 5.956z" /><path d="M6.497 23.303c-.378 0-.686.308-.686.686 0 .376.31.684.687.684.378 0 .686-.308.686-.685 0-.38-.308-.687-.686-.687m0 2.37c-.93 0-1.686-.755-1.686-1.684 0-.93.757-1.687 1.687-1.687s1.686.756 1.686 1.686c0 .928-.756 1.684-1.686 1.684M23.036 10.447c-.553 0-1-.447-1-1v-2.67c0-.554.447-1 1-1 .553 0 1 .446 1 1v2.67c0 .553-.447 1-1 1M23.545 23.303c-.378 0-.686.308-.686.686 0 .376.307.684.685.684.378 0 .686-.308.686-.685 0-.38-.307-.687-.685-.687m0 2.37c-.93 0-1.686-.755-1.686-1.684 0-.93.755-1.687 1.685-1.687s1.686.756 1.686 1.686c0 .928-.755 1.684-1.685 1.684" /></g></svg></symbol>
        <symbol id="social"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M28.39 19.823l-3.7-2.855h-8.43c-.348 0-.69-.02-1.027-.062-.547-.066-.938-.564-.87-1.113.066-.548.558-.94 1.113-.872.256.033.518.05.784.05h8.77c.222 0 .437.072.613.207L28 16.997V8.388C28 4.865 25.134 2 21.61 2h-5.22C12.866 2 10 4.866 10 8.39c0 1.772.746 3.48 2.046 4.686.405.376.43 1.01.054 1.413-.377.404-1.01.43-1.413.053C8.98 12.96 8 10.717 8 8.39 8 3.762 11.764 0 16.39 0h5.22C26.236 0 30 3.763 30 8.39v10.64c0 .382-.217.73-.56.898-.14.07-.29.103-.44.103-.217 0-.433-.07-.61-.207z" /><path d="M16.825 5.545c-.972 0-1.763.79-1.763 1.763 0 2.212 3.32 4.335 4.024 4.642.707-.31 4.027-2.445 4.027-4.642 0-.972-.79-1.763-1.763-1.763-.57 0-1.103.273-1.427.73l-.12.165c-.214.292-.383.52-.714.52h-.002c-.33.002-.5-.228-.715-.52l-.11-.152c-.334-.47-.867-.743-1.438-.743zm2.265 7.428c-.464 0-2.066-1.008-3.212-2.145-1.205-1.194-1.816-2.38-1.816-3.52 0-1.524 1.24-2.763 2.763-2.763.896 0 1.735.432 2.245 1.155l.018.025.026-.036c.503-.713 1.342-1.145 2.236-1.145 1.524 0 2.763 1.24 2.763 2.763 0 2.935-4.307 5.657-5.02 5.665h-.002zM7.087 29c-.552 0-1-.447-1-1 0-.553.448-1 1-1h9.89c.134 0 .25-.1.27-.234l1.08-6.452c.04-.248-.075-.406-.147-.48-.07-.073-.233-.187-.463-.162l-3.806.48c-.344.042-.68-.093-.9-.36-.217-.267-.282-.626-.172-.952.072-.213.18-.486.305-.8.49-1.23 1.4-3.516.703-4.538-.112-.166-.36-.308-.694-.4-.537 2.813-1.933 6.438-5.552 7.773-.517.2-1.138-.038-1.34-.552-.2-.514.012-1.078.526-1.28L6.908 19c2.2-.81 3.64-2.92 4.275-6.262.104-.548.437-1.033.913-1.33.474-.295 1.055-.38 1.587-.232.814.223 1.426.63 1.816 1.202 1.1 1.618.453 3.9-.178 5.582l2.145-.27c.8-.1 1.585.173 2.15.754.562.58.813 1.37.688 2.17l-1.08 6.452C19.05 28.19 18.106 29 16.976 29H7.088z" /><path d="M2 28h4.087v-8.97H2V28zm-1 2c-.553 0-1-.447-1-1V18.03c0-.55.447-1 1-1h6.087c.553 0 1 .45 1 1V29c0 .553-.447 1-1 1H1z" /></g></svg></symbol>
        <symbol id="checkout"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M4 28.113h23V18.07H4v10.043zm24 2H3c-.553 0-1-.447-1-1V17.07c0-.552.447-1 1-1h25c.553 0 1 .448 1 1v12.043c0 .553-.447 1-1 1zM23.197 14.47c-.416 0-.805-.26-.946-.676l-.933-2.733c-.065-.19-.07-.4-.016-.594l1.514-5.374v-2.31l-.843.517c-.304.186-.683.195-.998.025l-2.168-1.178-2.006 1.164c-.31.18-.69.18-.997.004l-2.046-1.167-2.13 1.175c-.313.172-.693.163-.997-.02l-.89-.534V5.23c0 .092-.014.182-.038.27L8.23 10.71l.833 2.438c.18.522-.1 1.09-.623 1.27-.523.174-1.092-.1-1.27-.624L6.24 11.06c-.066-.19-.072-.4-.018-.594l1.514-5.374V1c0-.36.194-.693.508-.87.313-.178.7-.17 1.007.013l1.913 1.15L13.28.122c.306-.168.676-.164.978.01l2.034 1.16L18.286.134c.303-.174.672-.18.98-.014l2.155 1.17L23.294.148c.308-.19.694-.195 1.01-.02.316.178.51.512.51.873v4.23c0 .092-.012.182-.036.27l-1.467 5.21.833 2.438c.18.522-.1 1.09-.623 1.27-.107.035-.216.053-.323.053" /><path d="M11.658 7.155h8.195v-1h-8.195M10.988 10.2h8.195v-1h-8.195M26 17.35c-.553 0-1-.448-1-1v-1.254H6v1.253c0 .552-.447 1-1 1-.553 0-1-.448-1-1v-2.254c0-.553.447-1 1-1h21c.553 0 1 .447 1 1v2.253c0 .552-.447 1-1 1M7.458 20.172c-.26 0-.47.212-.47.472s.21.47.47.47.472-.21.472-.47-.212-.472-.472-.472m0 1.943c-.81 0-1.47-.66-1.47-1.47 0-.813.66-1.473 1.47-1.473.812 0 1.472.66 1.472 1.472 0 .81-.66 1.47-1.472 1.47M11.516 20.172c-.26 0-.472.212-.472.472s.212.47.472.47.472-.21.472-.47-.212-.472-.472-.472m0 1.943c-.812 0-1.472-.66-1.472-1.47 0-.813.66-1.473 1.472-1.473.812 0 1.472.66 1.472 1.472 0 .81-.66 1.47-1.472 1.47" /></g></svg></symbol>
        <symbol id="next-chevron"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M8 16c-.256 0-.512-.098-.707-.293-.39-.39-.39-1.023 0-1.414L11.586 10 7.293 5.707c-.39-.39-.39-1.023 0-1.414s1.023-.39 1.414 0l5 5c.39.39.39 1.023 0 1.414l-5 5c-.195.195-.45.293-.707.293z" /></svg></symbol>
        <symbol id="next-chevron-down"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><path d="M21 5.176l-9.086 9.353-8.914-9.353-2.314 2.471 11.314 11.735 11.314-11.735-2.314-2.471z" /></svg></symbol>
        <symbol id="next-checkmark"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><path d="M23.6 5L22 3.4c-.5-.4-1.2-.4-1.7 0L8.5 15l-4.8-4.7c-.5-.4-1.2-.4-1.7 0L.3 11.9c-.5.4-.5 1.2 0 1.6l7.3 7.1c.5.4 1.2.4 1.7 0l14.3-14c.5-.4.5-1.1 0-1.6z" /></svg></symbol>
        <symbol id="next-import"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><g><path d="M12 16.6c0 .4.4.6.7.3l5.2-4.4c.2-.2.2-.5 0-.7l-5.2-4.4c-.3-.2-.7 0-.7.3V10H2c-.6 0-1 .4-1 1v2c0 .6.4 1 1 1h10v2.6zM21 0H10C8.3 0 7 1.3 7 3v5h3V3h11v18H10v-5H7v5c0 1.6 1.3 3 3 3h11c1.7 0 3-1.4 3-3V3c0-1.7-1.3-3-3-3z" /></g></svg></symbol>
        <symbol id="next-website"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M9.4 2c-.2 0-.3.3-.2.4l1.4 1.4-3.8 3.9c-.2.2-.2.6 0 .8l.8.8c.2.2.6.2.8 0l3.8-3.8 1.4 1.4c.2.2.4 0 .4-.2v-4.2c0-.3-.2-.5-.5-.5h-4.1zm.6 0h-6c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2v-6 2h-2v3c0 .6-.5 1-1 1h-6c-.6 0-1-.5-1-1v-6c0-.6.5-1 1-1h3v-2h2z" /></svg></symbol>
        <symbol id="next-search-16"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" enable-background="new 0 0 16 16"><path d="M0 5.667c0 3.125 2.542 5.667 5.667 5.667 1.202 0 2.315-.38 3.233-1.02l.455.456c-.07.5.082 1.025.466 1.41l3.334 3.332c.326.325.753.488 1.18.488.425 0 .852-.163 1.177-.488.652-.65.652-1.706 0-2.357L12.18 9.822c-.384-.384-.91-.536-1.41-.466l-.454-.456c.64-.918 1.02-2.03 1.02-3.233C11.333 2.542 8.79 0 5.666 0S0 2.542 0 5.667zm2 0C2 3.645 3.645 2 5.667 2s3.667 1.645 3.667 3.667-1.646 3.666-3.667 3.666S2 7.688 2 5.667z" /></svg></symbol>
        <symbol id="next-remove"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><path d="M19.5 22c-.2 0-.5-.1-.7-.3L12 14.9l-6.8 6.8c-.2.2-.4.3-.7.3-.2 0-.5-.1-.7-.3l-1.6-1.6c-.1-.2-.2-.4-.2-.6 0-.2.1-.5.3-.7L9.1 12 2.3 5.2C2.1 5 2 4.8 2 4.5c0-.2.1-.5.3-.7l1.6-1.6c.2-.1.4-.2.6-.2.3 0 .5.1.7.3L12 9.1l6.8-6.8c.2-.2.4-.3.7-.3.2 0 .5.1.7.3l1.6 1.6c.1.2.2.4.2.6 0 .2-.1.5-.3.7L14.9 12l6.8 6.8c.2.2.3.4.3.7 0 .2-.1.5-.3.7l-1.6 1.6c-.2.1-.4.2-.6.2z" /></svg></symbol>
        <symbol id="next-desktop"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M14 0H2C.897 0 0 .897 0 2v8c0 1.103.897 2 2 2h4.667v2h-2c-.552 0-1 .447-1 1 0 .553.448 1 1 1h6.667c.552 0 1-.447 1-1 0-.553-.448-1-1-1h-2v-2H14c1.104 0 2-.897 2-2V2c0-1.103-.896-2-2-2zM2 10V2h12v8H2z" /></svg></symbol>
        <symbol id="next-phone"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.7 0H6.3C5.6 0 5 .6 5 1.3v21.3c0 .8.6 1.4 1.3 1.4h12.3c.7 0 1.4-.587 1.4-1.287V1.3c0-.7-.6-1.3-1.3-1.3zm-6.2 22.6c-.7 0-1.3-.6-1.3-1.3 0-.7.6-1.3 1.3-1.3.7 0 1.3.6 1.3 1.3 0 .7-.6 1.3-1.3 1.3zm4.5-4c0 .2-.2.4-.4.4H8.4c-.2 0-.4-.2-.4-.4V3.4c0-.2.2-.4.4-.4h8.1c.3 0 .5.2.5.4v15.2z" /></svg></symbol>
        <symbol id="next-undo"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="M8.628 14H4.153C3.427 14 3 13.25 3 12.5s.427-1.302 1.153-1.5H8.24c1.304.198 2.713-.67 2.76-2.5-.047-1.757-1.124-2.506-2.55-2.506H4.975v2.638c-.035.308-.376.467-.586.262L0 4.5 4.39.094c.21-.205.55-.047.585.262v2.638H8.75c2.87 0 5.128 2.21 5.25 5.404C13.878 11.59 11.62 14 8.628 14z" /></svg></symbol>
        <symbol id="next-drag-handle"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5 11" enable-background="new 0 0 5 11"><path d="M1 2c-.6 0-1-.4-1-1 0-.5.4-1 1-1 .5 0 1 .4 1 1s-.4 1-1 1zm1 2c0-.6-.4-1-1-1s-1 .4-1 1c0 .5.4 1 1 1s1-.4 1-1zm0 3c0-.6-.4-1-1-1s-1 .4-1 1c0 .5.4 1 1 1s1-.4 1-1zm0 3c0-.6-.4-1-1-1-.5 0-1 .4-1 1 0 .5.4 1 1 1s1-.4 1-1zm3-9c0-.6-.4-1-1-1S3 .4 3 1c0 .5.4 1 1 1s1-.4 1-1zm0 3c0-.6-.4-1-1-1s-1 .4-1 1c0 .5.4 1 1 1s1-.4 1-1zm0 3c0-.6-.4-1-1-1s-1 .4-1 1c0 .5.4 1 1 1s1-.4 1-1zm0 3c0-.6-.4-1-1-1-.5 0-1 .4-1 1 0 .5.4 1 1 1s1-.4 1-1z" /></svg></symbol>
        <symbol id="add-section"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M26.082 6.747V2H4v4.164c0 .553-.447 1-1 1-.553 0-1-.447-1-1V1c0-.553.447-1 1-1h24.082c.552 0 1 .447 1 1v5.747c0 .553-.512.984-1.064.984 0 0-.936-.43-.936-.983zM3 29.997c-.553 0-1-.447-1-1v-5.333c0-.553.447-1 1-1 .553 0 1 .447 1 1v4.333h21.99v-4.582c0-.553.443-1.03.995-1.03s1 .477 1 1.03v5.582c0 .553-.448 1-1 1H3z" /><path d="M2 21.997h26v-14H2v14zm27.032 2H.968c-.534 0-.968-.447-.968-1v-16c0-.553.434-1 .968-1h28.064c.534 0 .968.447.968 1v16c0 .553-.434 1-.968 1z" /><path d="M20.51 19.966c-.277 0-.5-.224-.5-.5V10.56c0-.277.223-.5.5-.5.275 0 .5.223.5.5v8.906c0 .276-.225.5-.5.5" /><path d="M24.97 15.497h-8.94c-.275 0-.5-.224-.5-.5s.225-.5.5-.5h8.94c.275 0 .5.224.5.5s-.225.5-.5.5" /></g></svg></symbol>
        <symbol id="next-spinner"><svg preserveAspectRatio="xMinYMin"><circle class="next-spinner__ring" cx="50%" cy="50%" r="45%" /></svg></symbol>
        <symbol id="next-disclosure"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><path d="M4.8 8h14.4c.6 0 .9.7.6 1.2l-7.2 8.9c-.3.4-.8.4-1.1 0L4.2 9.2c-.4-.5 0-1.2.6-1.2z" /></svg></symbol>
        <symbol id="blog"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M7.477 13.5h15.046" /><path d="M2 22h14.92c.263 0 .516.104.702.288L22 26.608V23c0-.552.447-1 1-1h5V2H2v20zm21 8c-.258 0-.512-.1-.702-.288L16.51 24H1c-.553 0-1-.448-1-1V1c0-.552.447-1 1-1h28c.553 0 1 .448 1 1v22c0 .552-.447 1-1 1h-5v5c0 .403-.242.767-.614.923-.125.052-.256.077-.386.077z" /><path d="M6.976 14h16.047v-1H6.976" /><path d="M7.477 16.563h10.046" /><path d="M6.976 17.062h11.047v-1H6.976" /><path d="M7.477 10.438h15.046" /><path d="M6.976 10.938h16.047v-1H6.976" /><path d="M7.477 7.438h15.046" /><path d="M6.976 7.938h16.047v-1H6.976" /></g></svg></symbol>
        <symbol id="collection-section"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M11 28.037h17V7.003l-8.5-3.937L11 7.003v21.034zM29 30H10c-.552 0-1-.44-1-.982V6.38c0-.378.224-.725.574-.887l9.5-4.4c.27-.124.583-.124.853 0l9.5 4.4c.35.162.573.51.573.888V29.02c0 .543-.448.982-1 .982z" /><path d="M19.982 8c-.542 0-.982.44-.982.98 0 .543.44.984.982.984.54 0 .98-.44.98-.983 0-.54-.44-.98-.98-.98m0 2.964c-1.093 0-1.982-.89-1.982-1.983C18 7.89 18.89 7 19.982 7c1.093 0 1.98.89 1.98 1.98 0 1.094-.887 1.984-1.98 1.984M1 23h28.932v-1H1" /><path d="M9.51 30h-8.5C.454 30 0 29.56 0 29.018V6.38c0-.378.226-.725.58-.887l9.614-4.4c.273-.124.59-.124.863 0l4.363 1.998c.505.232.722.817.483 1.308-.24.49-.84.702-1.346.468l-3.932-1.8-8.602 3.937v21.034H9.51c.56 0 1.013.438 1.013.98 0 .544-.453.983-1.012.983" /></g></svg></symbol>
        <symbol id="collection-block"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M25 30.094H1c-.552 0-1-.447-1-1V1c0-.552.448-1 1-1h24c.552 0 1 .448 1 1v4.883c0 .553-.448 1-1 1s-1-.447-1-1V2H2v26.094h22V24.01c0-.554.448-1 1-1s1 .446 1 1v5.084c0 .553-.448 1-1 1z" /><path d="M9 23.01h5V7.947c0-.383.22-.734.566-.9l1.628-.784L15 5.69 9 8.577V23.01zm7 0h12V8.576L22 5.69l-6 2.887V23.01zm13 2H8c-.552 0-1-.448-1-1V7.947c0-.383.22-.734.566-.9l7-3.37c.275-.13.593-.13.868 0l3 1.443.064.035 3.068-1.476c.275-.132.593-.132.868 0l7 3.367c.346.167.566.518.566.9V24.01c0 .552-.448 1-1 1z" /><path d="M22.03 9.446c-.292 0-.53.238-.53.53 0 .294.238.532.53.532.294 0 .532-.238.532-.53 0-.294-.238-.532-.53-.532m0 2.063c-.845 0-1.532-.688-1.532-1.533 0-.844.687-1.53 1.53-1.53.845 0 1.532.686 1.532 1.53 0 .845-.687 1.532-1.53 1.532M7.5 19.012h22v-1h-22" /></g></svg></symbol>
        <symbol id="email"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M29 30H1c-.552 0-1-.447-1-1V13.014c0-.36.192-.69.504-.868l2.926-1.672c.48-.276 1.09-.108 1.364.372s.107 1.09-.372 1.364L2 13.594V28h26V13.594l-2.304-1.317c-.48-.274-.646-.884-.372-1.364.274-.48.885-.647 1.364-.372l2.808 1.606c.312.177.504.51.504.868V29c0 .553-.448 1-1 1z" /><path d="M4.063 18.108c-.552 0-1-.447-1-1V1c0-.553.447-1 1-1h22c.552 0 1 .447 1 1v16.057c0 .553-.448 1-1 1s-1-.447-1-1V2h-20v15.108c0 .553-.45 1-1 1" /><path d="M29 18.917H1c-.552 0-1-.447-1-1 0-.553.448-1 1-1h28c.552 0 1 .447 1 1 0 .553-.448 1-1 1M8.03 9.917h3.99v-4.02H8.03v4.02zm4.49 1H7.53c-.277 0-.5-.224-.5-.5v-5.02c0-.277.223-.5.5-.5h4.99c.277 0 .5.223.5.5v5.02c0 .276-.223.5-.5.5zM14.5 6.917h7.186v-1H14.5M14.5 9.948h7.186v-1H14.5M7.124 13.886h15.75v-1H7.125" /><path d="M27 29.5c-.113 0-.23-.038-.322-.117l-11.68-9.813-11.676 9.813c-.212.18-.527.15-.704-.062-.18-.21-.15-.525.06-.703l12-10.083c.186-.156.457-.156.643 0l12.002 10.083c.212.178.24.493.06.704-.1.12-.24.18-.383.18" /></g></svg></symbol>
        <symbol id="link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M1 30c-.552 0-1-.447-1-1V1c0-.553.448-1 1-1h25c.552 0 1 .447 1 1v5.625c0 .553-.448 1-1 1s-1-.447-1-1V2H2v26h23v-3.875c0-.553.448-1 1-1s1 .447 1 1V29c0 .553-.448 1-1 1H1z" /><path d="M6 23h22V8.005H6V23zm23 2H5c-.552 0-1-.447-1-1V7.005c0-.553.448-1 1-1h24c.552 0 1 .447 1 1V24c0 .553-.448 1-1 1z" /><path d="M22.064 20h-6.098c-1.083 0-1.965-.882-1.965-1.967v-3.015c0-1.085.883-1.967 1.966-1.967H18.5v1h-2.534c-.532 0-.965.434-.965.968v3.015c0 .533.434.967.966.967h6.098c.534 0 .968-.434.968-.967v-3.015c0-.534-.434-.967-.968-.967h-1.502v-1h1.502c1.084 0 1.968.883 1.968 1.968v3.015c0 1.085-.884 1.967-1.968 1.967" /><path d="M18.033 18.075H15.47v-1h2.563c.533 0 .967-.434.967-.967V12.99c0-.532-.434-.966-.967-.966h-6.098c-.533 0-.966.434-.966.967v3.118c0 .533.432.967.965.967H13.5v1h-1.565c-1.084 0-1.966-.882-1.966-1.967V12.99c0-1.084.88-1.966 1.965-1.966h6.098c1.084 0 1.967.882 1.967 1.967v3.118c0 1.085-.883 1.967-1.967 1.967" /></g></svg></symbol>
        <symbol id="map"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M29 30H1c-.552 0-1-.447-1-1V11c0-.553.448-1 1-1h6.68c.553 0 1 .447 1 1 0 .553-.447 1-1 1H2v16h26V12h-5.902c-.553 0-1-.447-1-1 0-.553.447-1 1-1H29c.552 0 1 .447 1 1v18c0 .553-.448 1-1 1" /><path d="M20.541 29.5c-.274 0-.498-.224-.498-.5V13.5c0-.276.223-.5.5-.5.275 0 .5.224.5.5V29c0 .276-.225.5-.5.5M9.5 29.5c-.276 0-.5-.224-.5-.5V13.5c0-.276.224-.5.5-.5s.5.224.5.5V29c0 .276-.224.5-.5.5" /><path d="M15 2c-3.568 0-6.47 2.903-6.47 6.472 0 2.776 3.28 7.2 6.47 10.55 3.19-3.35 6.47-7.774 6.47-10.55C21.47 4.902 18.57 2 15 2m0 19.232c-.415 0-.803-.165-1.095-.465-2.217-2.28-7.376-8.042-7.376-12.295C6.53 3.802 10.33 0 15 0c4.67 0 8.47 3.8 8.47 8.472 0 4.253-5.158 10.015-7.376 12.296-.29.3-.68.464-1.094.464" /><path d="M15 6.75c-.804 0-1.458.654-1.458 1.458 0 .805.654 1.46 1.458 1.46.804 0 1.458-.655 1.458-1.46 0-.804-.654-1.458-1.458-1.458m0 3.917c-1.355 0-2.458-1.104-2.458-2.46 0-1.354 1.103-2.457 2.458-2.457 1.355 0 2.458 1.103 2.458 2.458 0 1.355-1.103 2.46-2.458 2.46M6.292 26.167c-.144 0-.285-.062-.382-.177L.618 19.735c-.178-.21-.15-.526.06-.705.21-.176.525-.15.703.06l5.061 5.98 6.668-2.625c.085-.034.178-.043.27-.027l9.72 1.707 5.524-6.395c.18-.21.497-.232.704-.05.21.18.233.496.052.705l-5.71 6.61c-.113.132-.29.193-.462.164l-9.862-1.733-6.87 2.705c-.06.023-.12.035-.183.035" /></g></svg></symbol>
        <symbol id="picture"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M2.912 6.535c-.503 0-.912.41-.912.912v17.157c0 .503.41.912.912.912h24.27c.502 0 .912-.41.912-.912V7.447c0-.503-.41-.912-.912-.912H2.912zm24.27 20.98H2.912C1.306 27.516 0 26.21 0 24.606V7.446c0-1.605 1.306-2.912 2.912-2.912h24.27c1.605 0 2.912 1.307 2.912 2.912v17.157c0 1.606-1.307 2.912-2.912 2.912z" /><path d="M15.047 10.916c-3.09 0-5.605 2.515-5.605 5.605 0 3.09 2.514 5.606 5.605 5.606 3.09 0 5.605-2.515 5.605-5.605 0-3.09-2.514-5.604-5.605-5.604m0 13.21c-4.193 0-7.605-3.41-7.605-7.605 0-4.192 3.412-7.604 7.605-7.604 4.193 0 7.605 3.412 7.605 7.605 0 4.195-3.412 7.606-7.605 7.606M25.99 10.017c0 .805-.653 1.458-1.458 1.458-.806 0-1.46-.653-1.46-1.458 0-.805.654-1.458 1.46-1.458.805 0 1.458.652 1.458 1.457M9.541 6.518c-.55 0-.998-.43-.998-.982V5.5c0-.827-.673-1.5-1.5-1.5s-1.5.673-1.5 1.5c0 .553-.45 1.018-1 1.018-.552 0-1-.43-1-.982C3.542 3.57 5.112 2 7.042 2s3.5 1.57 3.5 3.5c0 .553-.448 1.018-1 1.018" /><path d="M15.047 20.557c-2.226 0-4.036-1.81-4.036-4.036 0-2.224 1.81-4.035 4.037-4.035 2.226 0 4.036 1.81 4.036 4.036 0 2.227-1.81 4.037-4.036 4.037zm0-7.072c-1.674 0-3.036 1.362-3.036 3.036 0 1.675 1.363 3.037 3.037 3.037s3.036-1.362 3.036-3.036c0-1.673-1.362-3.035-3.036-3.035zM28.7 16.517h-7.048c-.553 0-1-.447-1-1 0-.553.447-1 1-1H28.7c.552 0 1 .447 1 1 0 .553-.448 1-1 1M8.043 16.517H1.34c-.55 0-1-.447-1-1 0-.553.45-1 1-1h6.703c.552 0 1 .447 1 1 0 .553-.448 1-1 1" /></g></svg></symbol>
        <symbol id="picture-block"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M25 30H1c-.552 0-1-.448-1-1V1c0-.552.448-1 1-1h24c.552 0 1 .448 1 1v5.375c0 .552-.448 1-1 1s-1-.448-1-1V2H2v26h22v-3.25c0-.552.448-1 1-1s1 .448 1 1V29c0 .552-.448 1-1 1" /><path d="M7.912 8C7.41 8 7 8.41 7 8.912v13.166c0 .503.41.912.912.912h19.176c.503 0 .912-.41.912-.912V8.912C28 8.41 27.59 8 27.088 8H7.912zm19.176 16.99H7.912C6.306 24.99 5 23.684 5 22.078V8.912C5 7.306 6.306 6 7.912 6h19.176C28.694 6 30 7.306 30 8.912v13.166c0 1.606-1.306 2.912-2.912 2.912z" /><path d="M17.443 11.025c-2.512 0-4.556 2.044-4.556 4.556 0 2.514 2.044 4.558 4.556 4.558 2.513 0 4.557-2.044 4.557-4.557 0-2.51-2.044-4.555-4.557-4.555m0 11.113c-3.615 0-6.556-2.942-6.556-6.557 0-3.614 2.94-6.555 6.556-6.555 3.615 0 6.557 2.94 6.557 6.556s-2.942 6.558-6.557 6.558M26.788 10.47c0 .71-.577 1.287-1.288 1.287-.712 0-1.288-.577-1.288-1.288 0-.712.576-1.29 1.288-1.29.71 0 1.288.578 1.288 1.29M12.38 7.5c-.275 0-.5-.224-.5-.5V6H9.77v1c0 .276-.224.5-.5.5-.277 0-.5-.224-.5-.5V5.5c0-.276.223-.5.5-.5h3.113c.277 0 .5.224.5.5V7c0 .276-.223.5-.5.5" /><path d="M17.443 13.107c-1.364 0-2.475 1.11-2.475 2.475 0 1.364 1.11 2.475 2.475 2.475s2.475-1.11 2.475-2.475-1.11-2.475-2.475-2.475m0 5.95c-1.916 0-3.475-1.56-3.475-3.475 0-1.916 1.56-3.475 3.475-3.475 1.916 0 3.475 1.56 3.475 3.475 0 1.916-1.56 3.475-3.475 3.475M28.67 14.89h-5.93c-.277 0-.5-.225-.5-.5 0-.277.223-.5.5-.5h5.93c.275 0 .5.223.5.5 0 .275-.225.5-.5.5M11.29 14.89H6.288c-.277 0-.5-.225-.5-.5 0-.277.223-.5.5-.5h5.004c.277 0 .5.223.5.5 0 .275-.223.5-.5.5" /></g></svg></symbol>
        <symbol id="product-section"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M6 27.541l17.012.002V6.114l-8.506-4.01L6 6.114V27.543zm18.012 2.002H5c-.552 0-1-.448-1-1V5.482c0-.386.224-.74.574-.905L14.08.097c.27-.129.583-.129.853-.002l9.505 4.482c.35.165.574.52.574.904v23.061c0 .555-.448 1.002-1 1.002z" /><path d="M14.506 7.143c-.542 0-.982.44-.982.98 0 .543.44.984.982.984.54 0 .98-.44.98-.983 0-.54-.44-.98-.98-.98m0 2.963c-1.093 0-1.982-.89-1.982-1.983 0-1.092.89-1.98 1.982-1.98 1.093 0 1.98.888 1.98 1.98 0 1.093-.887 1.983-1.98 1.983M4.5 21.584h20.012v-1H4.5" /></g></svg></symbol>
        <symbol id="product-block"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M25 30.094H1c-.552 0-1-.447-1-1V1c0-.552.448-1 1-1h24c.552 0 1 .448 1 1v4.883c0 .552-.448 1-1 1s-1-.448-1-1V2H2v26.094h22V24.01c0-.553.448-1 1-1s1 .447 1 1v5.084c0 .553-.448 1-1 1z" /><path d="M16 23.01h12V8.575L22 5.69l-6 2.886V23.01zm13 2H15c-.552 0-1-.45-1-1V7.947c0-.384.22-.734.566-.9l7-3.37c.275-.13.593-.13.868 0l7 3.37c.346.166.566.516.566.9v16.06c0 .553-.448 1-1 1z" /><path d="M22.03 9.447c-.292 0-.53.238-.53.53 0 .294.238.532.53.532.294 0 .532-.24.532-.532 0-.293-.238-.53-.53-.53m0 2.062c-.845 0-1.532-.688-1.532-1.532 0-.844.687-1.53 1.53-1.53.845 0 1.532.686 1.532 1.53s-.687 1.532-1.53 1.532M14.435 19.01H29.5v-1H14.435" /></g></svg></symbol>
        <symbol id="search"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M11.823 19.276c-.256 0-.512-.098-.707-.293-.39-.39-.39-1.023 0-1.414l2.728-2.73c.39-.39 1.023-.39 1.414 0 .39.392.39 1.025 0 1.415l-2.728 2.728c-.195.195-.45.293-.707.293" /><path d="M20.57 2c-4.15 0-7.53 3.378-7.53 7.53 0 4.15 3.38 7.528 7.53 7.528s7.53-3.377 7.53-7.53C28.1 5.38 24.72 2 20.57 2m0 17.058c-5.254 0-9.53-4.275-9.53-9.53C11.04 4.275 15.317 0 20.57 0s9.53 4.274 9.53 9.53c0 5.253-4.276 9.528-9.53 9.528M2.41 27.69c.548.546 1.44.546 1.988 0l7.55-7.553-1.987-1.988-7.55 7.55c-.548.55-.548 1.44 0 1.99m.994 2.408c-.872 0-1.744-.332-2.408-.995-1.328-1.328-1.328-3.488 0-4.816l8.258-8.26c.188-.187.442-.292.707-.292.266 0 .52.105.708.293l3.402 3.402c.39.39.39 1.024 0 1.414l-8.258 8.26c-.664.662-1.536.994-2.408.994" /><path d="M16.588 14.012c-.128 0-.256-.05-.354-.146-1.158-1.16-1.796-2.7-1.796-4.336 0-1.638.638-3.178 1.796-4.336 1.16-1.16 2.698-1.797 4.336-1.797 1.638 0 3.178.638 4.336 1.797.196.195.196.51 0 .707-.195.196-.51.196-.707 0-.97-.97-2.26-1.503-3.63-1.503s-2.66.534-3.628 1.504c-.97.97-1.504 2.258-1.504 3.63 0 1.37.534 2.66 1.504 3.628.195.196.195.512 0 .708-.098.097-.226.146-.354.146" /></g></svg></symbol>
        <symbol id="sidebar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M20 28h8V2h-8v26zm9 2H19c-.553 0-1-.447-1-1V1c0-.553.447-1 1-1h10c.553 0 1 .447 1 1v28c0 .553-.447 1-1 1z" /><path d="M18.667 28H1c-.553 0-1-.447-1-1V3c0-.553.447-1 1-1h17.417c.553 0 1 .447 1 1 0 .553-.447 1-1 1H2v22h16.667c.553 0 1 .447 1 1 0 .553-.447 1-1 1M22.462 29.797c-.128 0-.256-.05-.354-.146-.195-.195-.195-.51 0-.707l6.68-6.68c.195-.195.512-.195.707 0 .196.196.196.513 0 .708l-6.68 6.68c-.097.098-.225.147-.353.147" /><path d="M19.292 17.293c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.85-9.85c.195-.195.512-.195.707 0 .195.195.195.512 0 .707l-9.85 9.85c-.097.097-.225.146-.353.146M19.292 22.518c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.85-9.85c.195-.194.512-.194.707 0 .195.196.195.513 0 .708l-9.85 9.85c-.097.097-.225.146-.353.146M19.292 27.742c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.85-9.85c.195-.194.512-.194.707 0 .195.196.195.513 0 .708l-9.85 9.85c-.097.097-.225.146-.353.146M19.292 12.068c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.85-9.848c.195-.195.512-.195.707 0 .195.195.195.512 0 .707l-9.85 9.85c-.097.096-.225.145-.353.145M19.292 6.797c-.128 0-.256-.05-.354-.146-.195-.195-.195-.51 0-.707L24.235.647c.196-.196.512-.196.707 0 .196.195.196.51 0 .707L19.646 6.65c-.098.098-.226.147-.354.147" /></g></svg></symbol>
        <symbol id="text"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M25 30.063H1c-.552 0-1-.448-1-1V1c0-.552.448-1 1-1h24c.552 0 1 .448 1 1v6.063c0 .55-.448 1-1 1s-1-.45-1-1V2H2v26.063h22v-5c0-.552.448-1 1-1s1 .448 1 1v6c0 .552-.448 1-1 1z" /><path d="M7 22.134h21V8.063H7v14.072zm22 2H6c-.552 0-1-.448-1-1V7.063c0-.55.448-1 1-1h23c.552 0 1 .45 1 1v16.072c0 .552-.448 1-1 1z" /><path d="M9.54 11.014h5.01v-1H9.54" /><path d="M11.47 14.482h1v-4.468h-1M16.5 11.014h9v-1h-9M16.5 13.986h9v-1h-9M9.542 16.959l15.958-.002v-1H9.542M9.542 20.087H25.5v-1H9.542" /></g></svg></symbol>
        <symbol id="text-section"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M3 7.668c-.552 0-1-.45-1-1V1c0-.552.448-1 1-1h24.083c.552 0 1 .448 1 1v5.5c0 .55-.448 1-1 1-.553 0-1-.45-1-1V2H4v4.668c0 .55-.448 1-1 1zM27.082 30.042H3c-.553 0-1-.448-1-1V24c0-.552.447-1 1-1 .553 0 1 .448 1 1v4.042h22.082V23.5c0-.552.448-1 1-1s1 .448 1 1v5.542c0 .552-.448 1-1 1" /><path d="M2 22.122h26V8H2v14.122zm27 2H1c-.552 0-1-.448-1-1V7c0-.552.448-1 1-1h28c.552 0 1 .448 1 1v16.122c0 .552-.448 1-1 1z" /><path d="M5.464 11h5.16v-1h-5.16" /><path d="M7.544 14.5h1V10h-1M12.584 11H24.51v-1H12.584M12.584 13.973H24.51v-1H12.584M5.464 16.945H24.51v-1H5.464M5.464 19.918H24.51v-1H5.464" /></g></svg></symbol>
        <symbol id="text-block"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M25 30.063H1c-.552 0-1-.448-1-1V1c0-.552.448-1 1-1h24c.552 0 1 .448 1 1v6.063c0 .55-.448 1-1 1s-1-.45-1-1V2H2v26.063h22v-5c0-.552.448-1 1-1s1 .448 1 1v6c0 .552-.448 1-1 1z" /><path d="M7 22.134h21V8.063H7v14.072zm22 2H6c-.552 0-1-.448-1-1V7.063c0-.55.448-1 1-1h23c.552 0 1 .45 1 1v16.072c0 .552-.448 1-1 1z" /><path d="M9.54 11.014h5.01v-1H9.54" /><path d="M11.47 14.482h1v-4.468h-1M16.5 11.014h9v-1h-9M16.5 13.986h9v-1h-9M9.542 16.959l15.958-.002v-1H9.542M9.542 20.087H25.5v-1H9.542" /></g></svg></symbol>
        <symbol id="add-block"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M25 29.976H1c-.552 0-1-.447-1-1V1c0-.552.448-1 1-1h24c.552 0 1 .448 1 1v5.976c0 .553-.448 1-1 1s-1-.447-1-1V2H2v25.976h22v-4c0-.553.448-1 1-1s1 .447 1 1v5c0 .553-.448 1-1 1z" /><path d="M8 21.976h20V7.996H8v13.98zm21 2H7c-.552 0-1-.447-1-1V6.996c0-.55.448-1 1-1h22c.552 0 1 .45 1 1v15.98c0 .553-.448 1-1 1z" /><path d="M20.54 19.94c-.275 0-.5-.225-.5-.5v-8.907c0-.276.225-.5.5-.5.277 0 .5.224.5.5v8.906c0 .275-.223.5-.5.5" /><path d="M25 15.47h-8.938c-.276 0-.5-.223-.5-.5 0-.275.224-.5.5-.5H25c.276 0 .5.225.5.5 0 .277-.224.5-.5.5" /></g></svg></symbol>
        <symbol id="section"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M27.041 30H2.96c-.554 0-1.002-.448-1.002-1v-8.583c0-.552.448-1 1-1 .553 0 1 .448 1 1V28h22.083l.002-7.583c0-.552.447-1 1-1 .55 0 1 .448 1 1V29c0 .552-.45 1-1 1zM2.96 11.17c-.553 0-1-.448-1-1V1c0-.553.447-1 1-1H27.04c.552 0 1 .447 1 1v8.917c0 .552-.448 1-1 1-.553 0-1-.448-1-1V2H3.96v8.17c0 .552-.45 1-1 1" /><path d="M2 18.935h26v-8H2v8zm27 2H1c-.552 0-1-.448-1-1v-10c0-.553.448-1 1-1h28c.552 0 1 .447 1 1v10c0 .552-.448 1-1 1z" /><path d="M22.76 20.35c-.128 0-.256-.048-.354-.145-.195-.196-.195-.512 0-.708l6.24-6.24c.196-.196.512-.196.708 0 .195.195.195.51 0 .707l-6.24 6.24c-.098.098-.226.147-.354.147M7.343 20.094c-.128 0-.256-.05-.354-.146-.196-.196-.196-.512 0-.708l9.145-9.146c.196-.195.512-.195.708 0 .195.196.195.512 0 .708l-9.146 9.146c-.098.097-.226.146-.354.146M13.167 19.495c-.128 0-.256-.05-.354-.146-.195-.197-.195-.513 0-.71l8.766-8.764c.194-.195.51-.195.706 0 .195.196.195.512 0 .707L13.52 19.35c-.097.096-.225.145-.353.145M17.792 20.094c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.146-9.146c.196-.195.512-.195.708 0 .195.196.195.512 0 .708l-9.146 9.146c-.098.097-.226.146-.354.146M1.862 20.35c-.128 0-.256-.048-.354-.145-.195-.196-.195-.512 0-.708l8.988-8.987c.196-.196.512-.196.707 0 .196.195.196.51 0 .707l-8.987 8.988c-.098.097-.226.146-.354.146M1 15.94c-.128 0-.256-.048-.354-.145-.195-.196-.195-.512 0-.708l5.212-5.21c.195-.196.512-.196.707 0 .195.195.195.51 0 .707l-5.21 5.21c-.1.098-.227.147-.355.147" /></g></svg></symbol>
        <symbol id="block"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g fill-rule="evenodd"><path d="M25.082 30H1c-.552 0-1-.448-1-1V1c0-.552.448-1 1-1h24.082c.552 0 1 .448 1 1v8.917c0 .552-.448 1-1 1s-1-.448-1-1V2H2v26h22.082v-7.583c0-.552.448-1 1-1s1 .448 1 1V29c0 .552-.448 1-1 1z" /><path d="M8.04 18.935h20v-8h-20v8zm21 2h-22c-.55 0-1-.448-1-1v-10c0-.553.45-1 1-1h22c.553 0 1 .447 1 1v10c0 .552-.447 1-1 1z" /><path d="M23.8 20.35c-.128 0-.256-.048-.354-.145-.195-.196-.195-.512 0-.708l5.24-5.24c.197-.196.513-.196.708 0 .196.195.196.51 0 .707l-5.24 5.24c-.098.098-.226.147-.354.147M8.384 20.094c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.147-9.146c.195-.195.512-.195.707 0 .195.196.195.512 0 .708l-9.146 9.146c-.098.097-.226.146-.354.146M13.203 20.5c-.128 0-.256-.05-.354-.146-.196-.196-.196-.512 0-.708l9.77-9.77c.195-.195.51-.195.707 0 .195.196.195.512 0 .707l-9.77 9.77c-.098.098-.226.147-.354.147M18.832 20.094c-.128 0-.256-.05-.354-.146-.195-.196-.195-.512 0-.708l9.147-9.146c.195-.195.512-.195.707 0 .195.196.195.512 0 .708l-9.146 9.146c-.098.097-.226.146-.354.146M7.04 16.213c-.127 0-.255-.05-.353-.146-.195-.196-.195-.512 0-.708l4.85-4.85c.195-.195.512-.195.707 0 .195.195.195.512 0 .707l-4.85 4.85c-.097.097-.225.146-.353.146" /></g></svg></symbol>
        <symbol id="next-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill-rule="evenodd"><path d="M15 23H2c-1.105 0-2-.895-2-2V9c0-1.105.895-2 2-2h3.2c.442 0 .8.358.8.8v2.4c0 .442-.358.8-.8.8h-.7c-.276 0-.5.224-.5.5v7c0 .276.224.5.5.5h8c.276 0 .5-.224.5-.5V11h-.2c-.442 0-.8-.358-.8-.8V7.8c0-.442.358-.8.8-.8H15c1.105 0 2 .895 2 2v12c0 1.105-.895 2-2 2" /><path d="M22 17h-3.2c-.442 0-.8-.358-.8-.8v-2.4c0-.442.358-.8.8-.8h.7c.276 0 .5-.224.5-.5v-7c0-.276-.224-.5-.5-.5h-8c-.276 0-.5.224-.5.5V13h.2c.442 0 .8.358.8.8v2.4c0 .442-.358.8-.8.8H9c-1.105 0-2-.895-2-2V3c0-1.105.895-2 2-2h13c1.105 0 2 .895 2 2v12c0 1.105-.895 2-2 2" /></g></svg></symbol>
        <symbol id="next-collections"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><g><path d="M18 9.3V3.1c0-.6-.5-1.1-1.1-1.1h-6.2c-.5 0-1 .2-1.4.6l-9 9c-.4.4-.4 1.1 0 1.6l6.5 6.5c.4.4 1.1.4 1.6 0l9-9c.4-.4.6-.9.6-1.4zM14 8c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM22.9 4h-2.4c-.3 0-.5.2-.5.5v6.1c0 .3-.1.6-.3.8l-8.2 8.2c-.2.2-.2.5 0 .7l1.4 1.4c.4.4 1.1.4 1.5 0l9.3-9.3c.2-.2.3-.5.3-.8V5.1c0-.6-.5-1.1-1.1-1.1z" /></g></svg></symbol>
        <symbol id="next-products"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><path d="M21.8 1h-7c-.8 0-1.5.3-2 .8L1.4 13.2c-.5.5-.5 1.3 0 1.8L9 22.7c.5.5 1.3.5 1.8 0l11.3-11.4c.5-.5.8-1.3.8-2v-7c.1-.7-.4-1.3-1.1-1.3zm-4 7.6c-1.3 0-2.3-1.1-2.3-2.3C15.5 5 16.6 4 17.8 4c1.3 0 2.3 1.1 2.3 2.3 0 1.3-1 2.3-2.3 2.3z" /></svg></symbol>
        <symbol id="next-pages"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><g><path d="M16.5 6h-15C.7 6 0 6.7 0 7.5v15c0 .8.7 1.5 1.5 1.5h15c.8 0 1.5-.7 1.5-1.5v-15c0-.8-.7-1.5-1.5-1.5zM13 20H5c-.6 0-1-.4-1-1s.4-1 1-1h8c.6 0 1 .4 1 1s-.4 1-1 1zm0-4H5c-.6 0-1-.4-1-1s.4-1 1-1h8c.6 0 1 .4 1 1s-.4 1-1 1zm0-4H5c-.6 0-1-.4-1-1s.4-1 1-1h8c.6 0 1 .4 1 1s-.4 1-1 1zM22.5 0h-15C6.7 0 6 .7 6 1.5v2c0 .3.2.5.5.5h12c.8 0 1.5.7 1.5 1.5v12c0 .3.2.5.5.5h2c.8 0 1.5-.7 1.5-1.5v-15c0-.8-.7-1.5-1.5-1.5z" /></g></svg></symbol>
        <symbol id="next-blogs"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><path d="M12 1C5.4 1 0 5.9 0 12c0 1.9.5 3.7 1.5 5.3L0 21.7c-.1.4 0 .8.2 1 .3.2.5.3.8.3.1 0 .2 0 .3-.1l4.5-1.5c1.9 1 4 1.6 6.2 1.6 6.6 0 12-4.9 12-11S18.6 1 12 1zm5 16H7c-.6 0-1-.4-1-1s.4-1 1-1h10c.6 0 1 .4 1 1s-.4 1-1 1zM6 12c0-.6.4-1 1-1h8c.6 0 1 .4 1 1s-.4 1-1 1H7c-.6 0-1-.4-1-1zm11-3H7c-.6 0-1-.4-1-1s.4-1 1-1h10c.6 0 1 .4 1 1s-.4 1-1 1z" /></svg></symbol>
        <symbol id="next-photos"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 8c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5-1.5-.7-1.5-1.5.7-1.5 1.5-1.5m0-1c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5zm15.5-4h-20c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2v-14c0-1.1-.9-2-2-2zm-20 2h20v9.6l-4.1-4.1c-1.3-1.3-3.5-1.3-4.9 0l-4 4c-1-.4-2.2-.2-3 .6l-3.9 3.9h-.1v-14zm5.4 11.5c.1-.1.1-.1.2-.1.3-.2.7-.1 1 .1l.6.6 1.9 1.9h-6.2l2.5-2.5zm6.6 2.5l-3.3-3.3 3.8-3.8c.6-.6 1.5-.6 2.1 0l5.5 5.5v1.6h-8.1z" /></svg></symbol>
        <symbol id="rte-bold"><svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 3 12 12" enable-background="new -1 3 12 12"><title>rte-bold</title><desc>Created with Sketch.</desc><path d="M9.7 9.8c-.3-.5-.4-.6-.7-.8-.3-.3-.7-.4-1.1-.6-.4-.1-.8-.2-1.1-.2v-.2l1-.3c.3-.2.6-.3.8-.5.3-.2.5-.5.6-.8.2-.3.2-.6.2-1 0-.8-.3-1.4-.9-1.8-.6-.4-1.6-.6-3-.6h-5.5v.7c.2.1.4.1.5.2.2.1.4.2.4.3.1.1.1.3.1.5v7.7c0 .2 0 .4-.1.5-.1.1-.2.2-.4.3-.1.1-.2.1-.4.1h-.1v.7h5.3c.7 0 1.4 0 2-.1.5-.1 1-.3 1.4-.6.4-.2.8-.5 1-.9.2-.3.3-.8.3-1.4 0-.4 0-.7-.3-1.2zm-6.2-6.1h1.3c.6 0 1.1.2 1.4.5.3.4.5.8.5 1.4 0 .7-.2 1.2-.6 1.6-.4.4-.9.6-1.7.6h-.9v-4.1zm3.1 9c-.3.4-.8.6-1.4.6-.3 0-1-.1-1.3-.2-.2-.1-.3-.3-.4-.5v-4h.7c.8 0 1.9.2 2.3.6.5.4.7 1 .7 1.7 0 .8-.2 1.4-.6 1.8z" /></svg></symbol>
        <symbol id="rte-italic"><svg xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" viewBox="-1 3 12 12" enable-background="new -1 3 12 12"><title>rte-italic</title><desc>Created with Sketch.</desc><path sketch:type="MSShapeGroup" d="M9 3l-.3 1c-.1 0-.4 0-.6.1-.3 0-.5.1-.6.1-.3.1-.5.2-.6.3l-.2.5-1.7 7v.2c0 .1 0 .2.1.3.1.1.2.2.3.2.1 0 .3.1.5.1.3.2.5.2.6.2l-.2 1h-5.3l.2-1h.7s.5-.1.6-.1c.2-.1.4-.2.5-.3.1-.1.2-.3.2-.5l1.8-7v-.30000000000000004c0-.1 0-.2-.1-.3 0-.1-.1-.1-.3-.2-.1-.1-.3-.1-.6-.2-.2 0-.4-.1-.5-.1l.2-1h5.3z" /></svg></symbol>
        <symbol id="phone"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="currentColor" d="M3 1h14v18H3V1z" /><path d="M17 0c.552 0 1 .447 1 1v18c0 .553-.448 1-1 1H3c-.552 0-1-.447-1-1V1c0-.553.448-1 1-1h14zM4 18h12V2H4v16zM9 6h2c.552 0 1-.447 1-1s-.448-1-1-1H9c-.552 0-1 .447-1 1s.448 1 1 1zm1 8c-.552 0-1 .447-1 1s.448 1 1 1 1-.447 1-1-.448-1-1-1z" /></svg></symbol>
        <symbol id="desktop"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="currentColor" d="M1 1h18v10H1V1z" /><path d="M13 14H2v-2h16v2h-5zm-.606 4H7.606c.16-.522.295-1.182.357-2h4.074c.062.818.196 1.478.357 2zM2 10V2h16v8H2zM19 0H1C.448 0 0 .447 0 1v14c0 .553.448 1 1 1h4.95c-.156 1.657-.66 2.293-.658 2.293-.285.286-.37.716-.216 1.09S5.596 20 6 20h8c.39 0 .734-.242.897-.598s.09-.788-.166-1.084c-.004-.007-.52-.64-.68-2.318H19c.552 0 1-.447 1-1V1c0-.553-.448-1-1-1z" /></svg></symbol>
        <symbol id="viewport-wide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Viewport-Wide</title><path d="M16.707 6.293l3 3c.39.39.39 1.023 0 1.414l-3 3c-.195.195-.45.293-.707.293s-.512-.098-.707-.293c-.39-.39-.39-1.023 0-1.414L16.586 11H12c-.552 0-1-.447-1-1s.448-1 1-1h4.586l-1.293-1.293c-.39-.39-.39-1.023 0-1.414s1.023-.39 1.414 0zm-12 0c.39.39.39 1.023 0 1.414L3.414 9H8c.552 0 1 .447 1 1s-.448 1-1 1H3.414l1.293 1.293c.39.39.39 1.023 0 1.414-.195.195-.45.293-.707.293s-.512-.098-.707-.293l-3-3c-.39-.39-.39-1.023 0-1.414l3-3c.39-.39 1.023-.39 1.414 0zM19 0c.552 0 1 .447 1 1v2c0 .553-.448 1-1 1s-1-.447-1-1V2H2v2c0 .553-.448 1-1 1s-1-.447-1-1V1c0-.553.448-1 1-1h18zm0 15c.552 0 1 .447 1 1v3c0 .553-.448 1-1 1H1c-.552 0-1-.447-1-1v-3c0-.553.448-1 1-1s1 .447 1 1v2h16v-2c0-.553.448-1 1-1z" /></svg></symbol>
        <symbol id="disclosure-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6.28 9.28l3.366 3.366c.196.196.512.196.708 0L13.72 9.28c.293-.293.293-.767 0-1.06-.14-.14-.332-.22-.53-.22H6.81c-.414 0-.75.336-.75.75 0 .2.08.39.22.53z" /></svg></symbol>
        <symbol id="logo-bizweb" viewBox="4.75 5.667 45.593 56.583"><path fill="#FFF" d="M45.269 7.663l-33.737 3.043c-3.678.381-4.819 2.156-4.819 4.82v34.498c0 2.664 2.156 4.946 4.946 4.946h.38c.507-2.536 2.79-4.438 5.454-4.438s4.946 1.902 5.454 4.438h11.922c.507-2.536 2.791-4.438 5.454-4.438s4.946 1.902 5.454 4.313c2.537-.254 4.566-2.283 4.566-4.82V12.609c-.128-2.79-2.284-4.946-5.074-4.946zm-.508 29.551c-.254 1.775-.761 3.425-1.521 4.819-.761 1.396-1.776 2.664-3.044 3.552-1.269.888-2.791 1.521-4.439 1.901-1.015.128-2.029.255-3.044.128-1.015-.128-1.776-.255-2.537-.509a6.636 6.636 0 0 1-1.902-1.015c-.507-.38-1.269-.888-2.156-1.647l.127.634c.253 1.269.126 2.282-.381 3.044s-1.268 1.27-2.156 1.396c-1.015.127-1.776 0-2.41-.509-.634-.507-1.141-1.521-1.395-2.79l-5.2-29.424c-.254-1.395-.127-2.41.253-3.297.38-.761 1.142-1.269 2.156-1.522 1.015-.127 1.902 0 2.537.634.761.634 1.141 1.521 1.395 2.79l1.775 10.273c1.015-1.522 2.156-2.791 3.298-3.678s2.79-1.522 4.692-1.902c2.283-.381 4.313-.254 6.215.507 1.902.761 3.424 2.029 4.819 3.932 1.269 1.902 2.156 4.186 2.664 6.976.381 2.029.508 3.931.254 5.707z" /><path fill="#FFF" d="M36.264 28.463c-.761-1.142-1.649-2.029-2.664-2.537-1.015-.508-2.283-.634-3.424-.507-1.269.254-2.41.761-3.298 1.649a6.364 6.364 0 0 0-1.775 3.424c-.38 1.396-.38 3.044 0 4.945.507 2.664 1.522 4.692 2.917 5.834 1.522 1.27 3.171 1.648 5.2 1.27 1.648-.254 3.044-1.27 4.059-3.044 1.015-1.647 1.141-3.933.761-6.722-.508-1.649-1.016-3.171-1.776-4.312z" /><circle fill="#FFF" cx="40.195" cy="56.239" r="3.424" /><circle fill="#FFF" cx="17.366" cy="56.239" r="3.424" /></symbol>
        <symbol id="next-checkmark-thick"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24"><path d="M23.6 5L22 3.4c-.5-.4-1.2-.4-1.7 0L8.5 15l-4.8-4.7c-.5-.4-1.2-.4-1.7 0L.3 11.9c-.5.4-.5 1.2 0 1.6l7.3 7.1c.5.4 1.2.4 1.7 0l14.3-14c.5-.4.5-1.1 0-1.6z" /></svg></symbol>
        <symbol id="delete-minor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M16 6a1 1 0 1 1 0 2h-1v9a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V8H4a1 1 0 1 1 0-2h12zM9 4a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2H9zm2 12h2V8h-2v8zm-4 0h2V8H7v8z" /></svg></symbol>
        <symbol id="cancel-small-minor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11.414 10l4.293-4.293c.391-.391.391-1.023 0-1.414s-1.023-.391-1.414 0l-4.293 4.293-4.293-4.293c-.391-.391-1.023-.391-1.414 0s-.391 1.023 0 1.414l4.293 4.293-4.293 4.293c-.391.391-.391 1.023 0 1.414.195.195.451.293.707.293.256 0 .512-.098.707-.293l4.293-4.293 4.293 4.293c.195.195.451.293.707.293.256 0 .512-.098.707-.293.391-.391.391-1.023 0-1.414l-4.293-4.293z"></path></svg></symbol>
        <symbol id="select-chevron"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z" /></svg></symbol>
        <symbol id="next-search-reverse"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M8 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm9.707 4.293l-4.82-4.82C13.585 10.493 14 9.296 14 8c0-3.313-2.687-6-6-6S2 4.687 2 8s2.687 6 6 6c1.296 0 2.492-.415 3.473-1.113l4.82 4.82c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414z" /></svg></symbol>
        <symbol id="arrow-detailed"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 17" enable-background="new 0 0 16 17"><path d="M7 3.411V16a1 1 0 0 0 2 0V3.411l4.96 4.963a1 1 0 1 0 1.414-1.414L8.707.289a1 1 0 0 0-1.414 0L.626 6.959a1 1 0 1 0 1.415 1.415L7 3.41z" /></svg></symbol>
        <symbol id="logo-sapo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 228.23 256.231">
                <path fill="#FFF" d="M228.23 50.593c0-25.008-20.27-45.277-45.271-45.277L45.27 27.994C20.262 27.994 0 48.264 0 73.272v137.686c0 25.002 20.262 45.273 45.27 45.273h137.689c25.002 0 45.271-20.271 45.271-45.273m-53.203 15.582c-15.955 11.01-35.23 16.514-57.789 16.514-32.488 0-62.484-11.695-90-35.094l29.402-29.727c18.195 19.547 39.191 29.313 62.938 29.313 9.109 0 17.537-1.926 25.27-5.771 9.672-4.662 14.486-11.104 14.486-19.355 0-12.074-8.807-19.764-26.432-23.066l-24.344-4.629c-21.75-4.135-37.852-9.361-48.301-15.689-15.674-9.639-23.539-23.395-23.539-41.297 0-20.368 8.273-36.609 24.781-48.727C76.09 38 93.979 32.496 115.166 32.496c26.971 0 53.395 9.232 79.277 27.663l-24.449 30.137c-17.676-14.864-35.648-22.292-53.867-22.292-8.842 0-16.848 1.939-24.025 5.784-8.566 4.681-12.848 11.138-12.848 19.405 0 10.737 8.793 17.745 26.43 21.066l43.328 8.245c35.246 6.596 52.857 24.363 52.857 53.264 0 21.471-8.951 38.385-26.842 50.772z" />
            </svg>
        </symbol>
    </svg>
</div>

<div>
    <div class="section-footer">

        <script type="text/javascript">
            $(document).ready(function () {
                $(".spectrum-color").spectrum({
                    showInput: true,
                    className: "full-spectrum",
                    showInitial: true,
                    showPalette: false,
                    showSelectionPalette: true,
                    maxSelectionSize: 10,
                    preferredFormat: "hex",
                    showButtons: false,
                    allowEmpty: true,
                    move: function (color) {
                        postMessageData("changeColor", {
                            key: $(this).data("color-setting"),
                            value: color ? color.toHexString() : null
                        });
                    },
                    show: function () {

                    },
                    beforeShow: function () {

                    },
                    hide: function () {

                    },
                    change: function (color) {
                        postMessageData("changeColor", {
                            key: $(this).data("color-setting"),
                            value: color ? color.toHexString() : null
                        });
                    }
                });
            });
            function postMessageData(message, data) {
                var postData = JSON.stringify({
                    message: message,
                    data: data
                });

                document.getElementById("theme-editor-iframe").contentWindow.postMessage(postData, window.location);

                if (data != null)
                    return data.callbackId

                return void 0;
            };

            function save_success(form, data) {
                let current_url = document.getElementById('theme-editor-iframe').src;
                $( '#theme-editor-iframe' ).attr( 'src', current_url);
            }
        </script>
    </div>
</div>
<div id="app-modal"></div>
</body>
</html>
