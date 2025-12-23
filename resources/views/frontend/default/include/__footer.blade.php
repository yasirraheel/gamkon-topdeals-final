@use(Illuminate\Support\Fluent)

@php
    $footerData = getLandingData('footer');
    $footerContent = new Fluent(json_decode($footerData['data'], true));
@endphp

@if ($footerContent !== null)
    <footer class="footer-1" data-background="{{ themeAsset('images/footer/footer-bg.png') }}">
        <div class="container">
            <div class="footer-top section_space-py">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="left">
                            <div class="logo">
                                <img src="{{ asset(setting('site_logo', 'global')) }}"
                                    alt="{{ setting('site_title', 'global') }}">
                            </div>
                            <p>{{ $footerContent['about_us'] }}</p>

                            <div class="email">
                                <a href="mailto:{{ $footerContent['contact_email_address'] }}">
                                    {{ $footerContent['contact_email_address'] }}
                                    <span>
                                        <iconify-icon icon="humbleicons:arrow-right" class="arrow-right"></iconify-icon>
                                    </span>
                                </a>
                            </div>

                            <div class="social-icons">
                                @foreach (\App\Models\Social::all() as $social)
                                    <a href="{{ url($social->url) }}">
                                        <iconify-icon icon="{{ $social->class_name }}" title="{{ $social->icon_name }}"
                                            class="social-icon"></iconify-icon>
                                    </a>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="right">
                            <div class="footer-links">
                                <div class="row g-4">
                                    <div class="col-sm-4 d-flex justify-content-start justify-content-md-center">
                                        <div class="footer-menu">
                                            <h4 class="footer-link-title">{{ $footerContent['footer_widget_1_title'] }}
                                            </h4>
                                            <ul>
                                                @foreach ($footer_navigation_1 as $fContent)
                                                    <li>
                                                        @if ($fContent->page_id == null)
                                                            <a
                                                                href="{{ url($fContent->url) }}">{{ $fContent->tname }}</a>
                                                        @else
                                                            <a
                                                                href="{{ url($fContent->page->url) }}">{{ $fContent->tname }}</a>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-start justify-content-md-end">
                                        <div class="footer-menu">
                                            <h4 class="footer-link-title">{{ $footerContent['footer_widget_2_title'] }}
                                            </h4>
                                            <ul>
                                                @foreach ($footer_navigation_2 as $fContent)
                                                    <li>
                                                        @if ($fContent->page_id == null)
                                                            <a
                                                                href="{{ url($fContent->url ?? '') }}">{{ $fContent->tname }}</a>
                                                        @else
                                                            <a
                                                                href="{{ url($fContent->page->url ?? '') }}">{{ $fContent->tname }}</a>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-start justify-content-md-end">
                                        <div class="footer-menu">
                                            <h4 class="footer-link-title">{{ $footerContent['footer_widget_3_title'] }}
                                            </h4>
                                            <ul>
                                                @foreach ($footer_navigation_3 as $fContent)
                                                    <li>
                                                        @if ($fContent->page_id == null)
                                                            <a href="{{ $fContent->url }}">{{ $fContent->tname }}</a>
                                                        @else
                                                            <a
                                                                href="{{ url($fContent->page->url ?? '') }}">{{ $fContent->tname }}</a>
                                                        @endif
                                                    </li>
                                                @endforeach
                                                <li class="mt-5">
                                                    <img src="{{ asset($footerContent['left_img']) }}" alt="">
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="left">
                    <p>{{ $footerContent['copyright_text'] }}</p>
                </div>
                <div class="right">
                    <ul>
                        @foreach ($footer_navigation_bottom as $fContent)
                            <li>
                                @if ($fContent->page_id == null)
                                    <a href="{{ $fContent->url }}">{{ strtoupper($fContent->tname) }}</a>
                                @else
                                    <a
                                        href="{{ url($fContent->page->url ?? '') }}">{{ strtoupper($fContent->tname) }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endif
