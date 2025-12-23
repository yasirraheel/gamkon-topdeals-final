@php
    if (!$data) {
        $data = getLandingData('faq');
    }
@endphp
@push('style')
    <style>
        .common-faq-box .accordion .accordion-item .accordion-button::before {
            background-image: url("{{ themeAsset('images/faq/accordion-arrow-plus.svg') }}") !important;
        }

        .common-faq-box .accordion .accordion-item .accordion-button:not(.collapsed)::before {
            background-image: url("{{ themeAsset('images/faq/accordion-arrow-cross.svg') }}") !important;
        }
    </style>
@endpush
<!-- faq area start -->
<section class="faq-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="middle-section-title">
            <div class="middle">
                <h2 class="wow img-custom-anim-top" data-wow-duration="1s" data-wow-delay="0.1s">
                    {{ $data['title'] ?? __('Frequently Asked Questions') }}</h2>
            </div>
        </div>
        <div class="faq-main-content title_mt">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="left wow img-custom-anim-left" data-wow-duration="1s" data-wow-delay="0.3s">
                        <div class="common-faq-box common-faq-box-2">
                            <div class="accordion" id="accordionExample">
                                @php
                                    $faqs = getLandingContents('faq');
                                @endphp
                                @forelse ($faqs as $index => $faq)
                                    <div class="accordion-item td-faq-accordion">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $index }}"
                                                aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $index }}">
                                                {{ $faq->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}"
                                            class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                            aria-labelledby="heading{{ $index }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{ $faq->description }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <x-luminous.no-data-found type="FAQ" />
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right wow img-custom-anim-right" data-wow-duration="1s" data-wow-delay="0.4s">
                        <div class="faq-img">
                            <img src="{{ $data['left_img'] ? asset($data['left_img']) : 'images/faq/faq-img.png' }}"
                                alt="FAQ Image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- faq area end -->
