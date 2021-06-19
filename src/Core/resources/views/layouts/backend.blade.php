<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('mymo/styles/images/icon.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('mymo/styles/css/backend.css') }}">
    @include('mymo_core::components.mymo_langs')

    <script src="{{ asset('mymo/styles/js/backend.js') }}"></script>
    <script src="{{ asset('mymo/styles/ckeditor/ckeditor.js') }}"></script>

    @yield('header')
</head>

<body class="cui__menuLeft--dark cui__topbar--fixed cui__menuLeft--unfixed">
<div class="cui__layout cui__layout--hasSider">

    <div class="cui__menuLeft">
        <div class="cui__menuLeft__mobileTrigger"><span></span></div>

        <div class="cui__menuLeft__outer">
            <div class="cui__menuLeft__logo__container">
                <div class="cui__menuLeft__logo">
                    <div class="cui__menuLeft__logo__name">
                        <a href="/{{ config('mymo_core.admin_prefix') }}" style="font-size: 25px">
                            <span style="color: #b71d37; text-shadow: #f7cccc 0.05em 0.05em 0.1em;">MYMO</span>
                            <span style="color: #0520e0; text-shadow: #d7dbf7 0.05em 0.05em 0.1em;">CMS</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="cui__menuLeft__scroll kit__customScroll">
                @include('mymo_core::backend.menu_left')
            </div>
        </div>
    </div>
    <div class="cui__menuLeft__backdrop"></div>

    <div class="cui__layout">
        <div class="cui__layout__header">
            @include('mymo_core::backend.menu_top')
        </div>

        <div class="cui__layout__content">
            @if(!request()->is(config('mymo_core.admin_prefix') . '/dashboard'))
            {{ breadcrumb('admin', [
                    [
                        'title' => $title
                    ]
                ]) }}
            @else
                <div class="mb-3"></div>
            @endif

            <h4 class="font-weight-bold ml-3">{{ $title }}</h4>

            <div class="cui__utils__content">
                @yield('content')
            </div>
        </div>
        <div class="cui__layout__footer">
            <div class="cui__footer">
                <div class="cui__footer__inner">
                    <a href="https://github.com/mymocms/mymocms" target="_blank" rel="noopener noreferrer" class="cui__footer__logo">
                        MYMO CMS - The Best Laravel CMS
                        <span></span>
                    </a>
                    <br />
                    <p class="mb-0">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by MYMO CMS
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.extend( $.validator.messages, {
        required: "{{ trans('mymo_core::app.this_field_is_required') }}",
    });

    $(".form-ajax").validate();
</script>

@yield('footer')
</body>
</html>