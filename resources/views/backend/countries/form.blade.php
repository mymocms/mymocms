@section('title', $title)

@section('content')
{{ Breadcrumbs::render('manager', [
    'name' => trans('app.countries'),
    'url' => route('admin.countries')
], $model) }}

<div class="cui__utils__content">
    <form method="post" action="" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                            <a href="{{ route('admin.countries') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label" for="baseName">@lang('app.name')</label>

                            <input type="text" name="name" class="form-control" id="baseName" value="" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="baseDescription">@lang('app.description')</label>
                            <textarea class="form-control" name="description" id="baseDescription" rows="6">{{ $model->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="baseStatus">@lang('app.status')</label>
                            <select name="status" id="baseStatus" class="form-control">
                                <option value="1">@lang('app.enabled')</option>
                                <option value="0">@lang('app.disabled')</option>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>
</div>
@endsection