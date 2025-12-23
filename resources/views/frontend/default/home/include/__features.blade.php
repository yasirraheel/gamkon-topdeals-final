@php
    $data = new \Illuminate\Support\Fluent(json_decode(getLandingData('features')['data'], true));
    $content = getLandingContents('features');
@endphp

<!-- use full features area start -->
<section class="use-full-features-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="usefull-feature-area-full">
            <div class="title">
                <h2>{{ $data['title'] }}</h2>
            </div>
            <div class="all-usefull-card title_mt">
                <div class="row g-4 all-usefull-card-row">
                    @foreach ($content as $item)
                        <div class="col-sm-6 col-lg-3 all-usefull-card-col">
                            <div class="usefull-card">
                                <div class="icon">
                                    <img src="{{ asset($item->icon) }}" alt="">
                                </div>
                                <div class="content">
                                    <h5>{{ $item->title }}</h5>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- use full features area end -->
