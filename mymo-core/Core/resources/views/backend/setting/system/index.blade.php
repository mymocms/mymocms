@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.system_setting'),
        'url' => route('admin.setting')
    ]) }}

<div class="cui__utils__content">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group" id="setting-menu">
                        @foreach($settings as $key => $setting)
                        <a href="{{ route('admin.setting.form', [$key]) }}" class="list-group-item @if($key == $form) active @endif" data-form="general">{{ $setting }}</a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">

            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold">{{ @$settings[$form] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="setting-form">
                    {!! $form_content !!}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection