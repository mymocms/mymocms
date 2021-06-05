<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('mymo_core::app.home_title') }}</label>
    <input name="setting[title]" class="next-input" value="{{ get_config('title') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('mymo_core::app.home_description') }}</label>
    <textarea name="setting[description]" class="next-input">{{ get_config('shop_description') }}</textarea>
</div>

<div class="theme-setting theme-setting--text editor-item">
<label class="next-label" for="input-logo">{{ trans('mymo_core::app.logo') }}</label>
<div class="review" id="review-logo">
    <img src="{{ image_url(get_config('logo')) }}" alt="">
</div>

<p><a href="javascript:void(0)" class="load-media" data-input="input-logo" data-preview="review-logo"><i class="fa fa-edit"></i> {{ trans('mymo_core::app.change') }}</a></p>
<input type="hidden" name="setting[logo]" id="input-logo" value="{{ get_config('logo') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label" for="input-icon">{{ trans('mymo_core::app.icon') }}</label>
    <div class="review" id="review-icon">
        <img src="{{ image_url(get_config('icon')) }}" alt="">
    </div>

    <p><a href="javascript:void(0)" class="load-media" data-input="input-icon" data-preview="review-icon"><i class="fa fa-edit"></i> {{ trans('mymo_core::app.change') }}</a></p>
    <input type="hidden" name="setting[icon]" id="input-icon" value="{{ get_config('icon') }}">
</div>