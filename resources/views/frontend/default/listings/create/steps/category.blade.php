<form action="{{ buyerSellerRoute('listing.' . ($listing ? 'edit' : 'create'), ['description', $listing?->enc_id]) }}">
    @php
        $inputName = 'category_id';
    @endphp
    @include('frontend::listings.include.__category-box', compact('data', 'inputName', 'listing'))
    <div id="subCatWrapper">

    </div>
    <div id="submitWrapper">
        <div class="select-category-btn mt-4">
            <button type="submit"
                class="primary-button primary-button-blue xl-btn w-100">{{ __('Select Category') }}</button>
        </div>
    </div>
</form>
@push('js')
    <script>
        "use strict";
        $(document).on('click', '.categoryBtn', function(e) {
            var cat = $(this).data('id');
            getCategoryHtml(cat)
        })

        function getCategoryHtml(cat, listing_id = null) {
            var url = "{{ buyerSellerRoute('listing.get.sub.cat.html', '___') }}"
            $.ajax({
                url: url.replaceAll('___', cat),
                data: {
                    listing_id: listing_id
                },
                success: (e) => {
                    if (e.success) {
                        $('#subCatWrapper').html(e.html)
                    } else {
                        $('#subCatWrapper').html('')
                    }
                }
            })
        }

        $(document).ready(function() {
            @isset($listing)
                getCategoryHtml({{ $listing->category_id }}, '{{ $listing->enc_id }}')
            @else
                getCategoryHtml({{ $data['categories']->first()->id ?? 0 }})
            @endisset
        });
    </script>
@endpush
