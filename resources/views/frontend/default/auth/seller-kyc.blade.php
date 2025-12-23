@foreach (json_decode($kyc->fields, true) as $key => $field)
    <div class="{{ $field['type'] == 'file' ? 'col-md-12' : 'col-md-6' }}">
        @if ($field['type'] == 'file')
            <div class="common-upload-image-system">
                <div class="title">
                    <div class="left">
                        <p>{{ $field['name'] }}@if ($field['validation'] == 'required')
                                <sup>*</sup>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="upload-container">
                    <div for="fileInput{{ $key }}" class="upload-thumb">
                        <div class="upload-thumb-inner">
                            <input type="file" class="file-upload-input" name="kyc_credential[{{ $field['name'] }}]"
                                id="fileInput{{ $key }}" multiple hidden>
                            <div class="upload-thumb-img">
                                <!-- Preview images will appear here -->
                            </div>
                            <div class="upload-thumb-content">
                                <h4><a href="#" class="attach-file">{{ __('Attach File') }}</a>
                                    {{ __('Or Drag & Drop') }}</h4>
                                <p>{{ __('JPEG/PNG/PDF/Docs file') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($field['type'] == 'textarea')
            <div class="td-form-group">
                <label class="input-label">{{ $field['name'] }}
                    @if ($field['validation'] == 'required')
                        <span>*</span>
                    @endif
                </label>
                <div class="input-field">
                    <textarea name="kyc_credential[{{ $field['name'] }}]" @if ($field['validation'] == 'required') required @endif></textarea>
                </div>
                <p class="feedback-invalid">{{ __('This field is required') }}</p>
            </div>
        @elseif($field['type'] == 'date')
            <div class="td-form-group birth-date-picker common-flatpicker-design">
                <label class="input-label">{{ $field['name'] }}
                    @if ($field['validation'] == 'required')
                        <span>*</span>
                    @endif
                </label>
                <div class="input-field">
                    <input type="text" class="form-control" id="flatpickr-date"
                        name="kyc_credential[{{ $field['name'] }}]" @if ($field['validation'] == 'required') required @endif>
                </div>
                <p class="feedback-invalid">{{ __('This field is required') }}</p>
            </div>
        @elseif($field['type'] == 'select')
            <div class="td-form-group">
                <label class="input-label">{{ $field['name'] }}
                    @if ($field['validation'] == 'required')
                        <span>*</span>
                    @endif
                </label>
                <div class="auth-nice-select auth-nice-select-2">
                    <select class="nice-select-active" name="kyc_credential[{{ $field['name'] }}]"
                        @if ($field['validation'] == 'required') required @endif>
                        @foreach ($field['options'] ?? [] as $option)
                            <option value="{{ $option['value'] }}" {{ $option['selected'] ? 'selected' : '' }}>
                                {{ $option['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="feedback-invalid">{{ __('This field is required') }}</p>
            </div>
        @else
            <div class="td-form-group">
                <label class="input-label">{{ $field['name'] }}
                    @if ($field['validation'] == 'required')
                        <span>*</span>
                    @endif
                </label>
                <div class="input-field">
                    <input type="text" class="form-control" name="kyc_credential[{{ $field['name'] }}]"
                        @if ($field['validation'] == 'required') required @endif>
                </div>
                <p class="feedback-invalid">{{ __('This field is required') }}</p>
            </div>
        @endif
    </div>
@endforeach
