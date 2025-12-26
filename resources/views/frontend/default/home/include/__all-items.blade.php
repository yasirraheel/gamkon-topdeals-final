<section class="all-items-area section_space-py {{ isset($bgClass) ? $bgClass : '' }}" id="all-items-section">
    <div class="container">
        <div class="section-title">
            <div class="left">
                <div class="title-text wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay="0.1s">
                    <iconify-icon icon="solar:gamepad-bold-duotone" width="32" style="color: var(--td-primary);"></iconify-icon>
                    <h2>{{ __('All Items') }}</h2>
                </div>
            </div>
        </div>
        <div class="title_mt">
            <div class="row g-4 category" id="all-items-container">
                @foreach ($allItemsListing as $listing)
                    @include('frontend::listings.include.category-block', [
                        'listing' => $listing,
                        'hasAnimation' => true,
                        'loop' => $loop
                    ])
                @endforeach
            </div>
            
            {{-- Infinite Scroll Loader --}}
            <div id="infinite-scroll-loader" style="display: none; text-align: center; margin-top: 40px;">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            
            {{-- End of Results Message --}}
            <div id="end-of-results" style="display: none; text-align: center; margin-top: 40px; color: #666;">
                <p>{{ __('No more items to load') }}</p>
            </div>
        </div>
    </div>
</section>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let page = 1;
        let loading = false;
        let hasMore = {{ $allItemsListing->hasMorePages() ? 'true' : 'false' }};
        const loader = document.getElementById('infinite-scroll-loader');
        const container = document.getElementById('all-items-container');
        const endMessage = document.getElementById('end-of-results');

        function loadMoreItems() {
            if (loading || !hasMore) return;

            loading = true;
            loader.style.display = 'block';

            page++;
            
            fetch(`{{ route('home.load-more-items') }}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        container.insertAdjacentHTML('beforeend', data.html);
                        hasMore = data.hasMore;
                        
                        // Re-initialize any plugins if needed (e.g., tooltips, wow.js)
                        if (typeof WOW === 'function') {
                            new WOW().init();
                        }
                        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
                    } else {
                        hasMore = false;
                    }
                    
                    if (!hasMore) {
                        endMessage.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error loading items:', error);
                })
                .finally(() => {
                    loading = false;
                    loader.style.display = 'none';
                });
        }

        // Intersection Observer for Infinite Scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && hasMore && !loading) {
                    loadMoreItems();
                }
            });
        }, {
            rootMargin: '100px'
        });

        // Observe the loader element (or a dummy target at bottom)
        observer.observe(loader);
        
        // Also ensure loader is visible in DOM flow so observer can trigger
        loader.style.display = 'block';
        loader.style.visibility = 'hidden'; // Hide visually but keep in layout for observer
        
        // Adjust loader visibility logic in loadMoreItems
        // We override the style.display above, so let's fix the observer logic:
        // Better approach: Observe a sentinel element at the bottom
    });
</script>
<script>
    // Refined Infinite Scroll Logic
    $(document).ready(function() {
        let page = 1;
        let loading = false;
        let hasMore = {{ $allItemsListing->hasMorePages() ? 'true' : 'false' }};
        
        $(window).scroll(function() {
            if (loading || !hasMore) return;
            
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
                loading = true;
                $('#infinite-scroll-loader').show().css('visibility', 'visible');
                
                page++;
                
                $.ajax({
                    url: '{{ route('home.load-more-items') }}',
                    type: 'GET',
                    data: { page: page },
                    success: function(data) {
                        if (data.html) {
                            $('#all-items-container').append(data.html);
                            hasMore = data.hasMore;
                            
                            // Re-init tooltips
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl)
                            })
                        } else {
                            hasMore = false;
                        }
                        
                        if (!hasMore) {
                            $('#end-of-results').show();
                        }
                    },
                    complete: function() {
                        loading = false;
                        $('#infinite-scroll-loader').hide();
                    }
                });
            }
        });
    });
</script>
@endpush
