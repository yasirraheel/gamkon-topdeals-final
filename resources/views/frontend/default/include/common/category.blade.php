<div class="category-buttons">
    <a href="#" class="category-btn" data-slug="all" data-category="All Service">
        <div class="img">
            <img src="{{ themeAsset('images/category-icon/category-icon-fill-1.svg') }}" alt="CATEGORY ICON">
        </div>
        <p>{{ __('All Categories') }}</p>
    </a>
    @foreach ($categories as $category)
        <a href="#" class="category-btn" data-slug="{{ $category->slug }}" data-category="{{ $category->name }}">
            <div class="img">
                <img width="24" src="{{ asset($category->image) }}" alt="{{ $category->name }}">
            </div>
            <p>{{ $category->name }}</p>
        </a>
    @endforeach
</div>
