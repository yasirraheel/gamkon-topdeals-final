<h3 class="title">{{ __('Edit Testimonial') }}</h3>
@include('backend.page.include.__language_bar', ['editMode' => true])

<div class="tab-content" id="pills-tabContent">
    @foreach ($groupData as $key => $landingContent)
        <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : '' }}" id="{{ $key }}-render" role="tabpanel"
            aria-labelledby="pills-render-tab">
            <form action="{{ route('admin.page.testimonial.update', $landingContent->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="locale" value="{{ $key }}">
                <div class="site-input-groups">
                    <label for="" class="box-input-label">{{ __('Name:') }}</label>
                    <input type="text" name="name" class="box-input mb-0" placeholder="{{ __('Name') }}"
                        value="{{ $landingContent->name }}" required="" />
                </div>
                @if ($key == 'en')
                <div class="site-input-groups">
                    <label for="" class="box-input-label">{{ __('Star:') }}</label>
                    <input type="text" name="star" class="box-input mb-0" placeholder="Out of 5" value="{{ $landingContent->star }}" required="" />
                </div>
                @endif
                <div class="site-input-groups">
                    <label for="" class="box-input-label">{{ __('Designation:') }}</label>
                    <input type="text" name="designation" class="box-input mb-0" placeholder="{{ __('Designation') }}"
                        value="{{ $landingContent->designation }}" required="" />
                </div>
                <div class="site-input-groups">
                    <label for="" class="box-input-label">{{ __('Message:') }}</label>
                    <textarea name="message" class="form-textarea mb-0"
                        placeholder="{{ __('Message') }}">{{ $landingContent->message }}</textarea>
                </div>

                <div class="action-btns">
                    <button type="submit" class="site-btn-sm primary-btn me-2">
                        <i data-lucide="check"></i>
                        {{ __('Update') }}
                    </button>
                    <a href="#" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i data-lucide="x"></i>
                        {{ __('Close') }}
                    </a>
                </div>
            </form>

        </div>
    @endforeach
</div>