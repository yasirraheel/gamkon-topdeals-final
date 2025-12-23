@php
    $isCategory = $inputName == 'category_id';
@endphp
<div class="choose-common">
    <h4>{{ __('Choose a :type', ['type' => $isCategory ? 'Category' : 'Sub Category']) }}</h4>
    <div class="all-common all-common-3">
        <div class="all-cards">
            @foreach ($data['categories'] as $category)
                <label for="{{ !$isCategory ? 'sub' : '' }}category_{{ $category->id }}" class="category">
                    <div @class([
                        'category-box',
                        'active' =>
                            (!isset($listing) && $loop->first) ||
                            ((isset($listing) &&
                                $isCategory &&
                                $listing->category_id == $category->id) ||
                                (isset($listing) &&
                                    !$isCategory &&
                                    $listing->subcategory_id == $category->id)),
                    ])>
                        <input data-id="{{ $category->id }}"
                            id="{{ !$isCategory ? 'sub' : '' }}category_{{ $category->id }}" value="{{ $category->id }}"
                            name="{{ $inputName ?? 'category_id' }}" type="checkbox"
                            class="{{ $isCategory ? 'categoryBtn' : 'subCategoryBtn' }} d-none"
                            @checked(
                                (!isset($listing) && $loop->first) ||
                                    ((isset($listing) && $isCategory && $listing->category_id == $category->id) ||
                                        (isset($listing) && !$isCategory && $listing->subcategory_id == $category->id))) class="d-none">
                        <div class="choose-card">
                            <div class="img-full"
                                data-background="{{ themeAsset('images/games-icon/games-card-bg.png') }}">
                                <div class="img">
                                    <img src="{{ asset($category->image) }}" alt="">
                                </div>
                            </div>
                            <p>{{ $category->name }}</p>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>

    </div>
</div>
