<!-- category area start -->
<section
    class="category-area section_space-py {{ isset($bgClass) ? $bgClass : '' }} section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="section-title">
            <div class="left">
                <div class="title-text wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    <img src="{{ themeAsset('images/icon/fire.svg') }}" alt="Fire Icon" />
                    <h2>{{ $data['title'] ?? __('Trending Category') }}</h2>
                </div>
            </div>
            <div class="right wow img-custom-anim-right" data-wow-duration="1.5s" data-wow-delay="0.2s">
                <a href="{{ route('categories') }}" class="view-all">{{ __('See All Category') }}</a>
            </div>
        </div>
        <div class="category-all title_mt">
            <div class="category-all-card">
                @php
                    $categories = \App\Models\Category::trending()
                        ->oldest('order')
                        ->isCategory()
                        ->withCount('listings')
                        ->take(7)
                        ->get();
                @endphp
                @foreach ($categories as $index => $category)
                    <a href="{{ route('category.listing', $category->slug) }}"
                        class="category-card wow img-custom-anim-top" data-wow-duration="1.5s"
                        data-wow-delay="{{ 0.3 + $index * 0.1 }}s">
                        <div class="icon">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" />
                        </div>
                        <div class="text">
                            <h5>{{ $category->name }}</h5>
                            <p>{{ $category->listings_count }} {{ __('Offers') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- category area end -->
