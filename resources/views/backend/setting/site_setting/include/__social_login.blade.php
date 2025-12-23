<div class="">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{ __($fields['title']) }}</h3>
        </div>
        <div class="site-card-body">

            @include('backend.setting.site_setting.include.form.__open_action')

            @foreach ($fields['elements'] as $key => $field)
                @php
                    $social = str($field['name'])->before('_');
                @endphp
                @if ($field['type'] == 'checkbox')
                    <div class="site-input-groups row">
                        <label for="" class="col-sm-4 col-label">{{ __($field['label']) }}
                        </label>
                        <div class="col-sm-8">
                            <div class="form-switch ps-0">
                                <input class="form-check-input" type="hidden" value="0"
                                    name="{{ $field['name'] }}" />
                                <div class="switch-field same-type m-0">
                                    <input
                                        onchange="fieldActiveToggle('{{ $field['name'] }}','.{{ $field['name'] }}-inputs')"
                                        type="radio" id="{{ $field['name'] }}-enable" name="{{ $field['name'] }}"
                                        value="1" @if (oldSetting($field['name'], $section)) checked @endif />
                                    <label for="{{ $field['name'] }}-enable">{{ __('Yes') }}</label>
                                    <input
                                        onchange="fieldActiveToggle('{{ $field['name'] }}','.{{ $field['name'] }}-inputs')"
                                        type="radio" id="{{ $field['name'] }}-disable" name="{{ $field['name'] }}"
                                        value="0" @if (!oldSetting($field['name'], $section)) checked @endif />
                                    <label for="{{ $field['name'] }}-disable">{{ __('No') }}</label>
                                </div>
                                <small class="text-muted">
                                    @if (str_ends_with($field['name'], 'social_login'))
                                        {{ __('Use :socialName callback url: :callBackUrl', [
                                            'socialName' => $social->title(),
                                            'callBackUrl' => route('social.login.callback', $social->lower()),
                                        ]) }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="site-input-groups row {{ $social }}_social_login-inputs {{ oldSetting($social . '_social_login', $section) == 0 ? 'd-none' : '' }}">
                        <label for="" class="col-sm-4 col-label">{{ __($field['label']) }}</label>
                        <div class="col-sm-8">
                            <div class="input-group joint-input">

                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                    class=" form-control {{ $errors->has($field['name']) ? 'has-error' : '' }}"
                                    value="{{ oldSetting($field['name'], $section) }}" />
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>
