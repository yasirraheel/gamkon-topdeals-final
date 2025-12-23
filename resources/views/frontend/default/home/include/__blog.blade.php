@php
    $blogs = \App\Models\Blog::where('locale', app()->getLocale())
        ->latest()
        ->paginate(4);
    if (!$data) {
        $data = getLandingData('blog');
    }
@endphp
<section class="blogs-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}">
    <div class="container">
        <div class="section-title">
            <div class="left">
                <div class="title-text wow img-custom-anim-left" data-wow-duration="1s" data-wow-delay="0.1s">
                    <h2>{{ $data['title'] }}</h2>
                </div>
            </div>
            <div class="right wow img-custom-anim-right" data-wow-duration="1s" data-wow-delay="0.2s">
                <a href="{{ route('page', 'blog') }}" class="view-all">{{ __('View All') }}</a>
            </div>
        </div>
        <div class="blogs-area-content title_mt">
            <div class="row g-4">
                @forelse($blogs as $blog)
                    @include('frontend::pages.include.__blog-card')
                @empty
                    <x-luminous.no-data-found type="{{ __('Blog Posts') }}" />
                @endforelse
            </div>
        </div>
    </div>
</section>
