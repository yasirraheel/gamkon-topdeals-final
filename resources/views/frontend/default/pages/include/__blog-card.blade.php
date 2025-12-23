<div class="col-sm-6 col-lg-4 col-xl-3">
    <div class="blog-card wow img-custom-anim-top" data-wow-duration="1s" data-wow-delay="{{ 0.3 + $loop->index * 0.1 }}s">
        <div class="full-card">
            <div class="blog-image">
                <a href="{{ route('blog-details', $blog->slug) }}" class="img-box">
                    <img src="{{ asset($blog->cover) }}" alt="{{ $blog->title }}">
                </a>
            </div>
            <div class="blog-content">
                @if ($blog->category)
                    <a href="{{ route('blog-category', $blog->category->slug) }}"
                        class="category">{{ $blog->category->name }}</a>
                @endif
                <h3>
                    <a href="{{ route('blog-details', $blog->slug) }}">{{ $blog->title }}</a>
                </h3>
                @if ($blog->details)
                    <p class="des">{{ Str::limit(strip_tags($blog->details), 90) }}</p>
                @endif
                <p class="date-text">{{ now()->parse($blog->created_at)->format('F d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
