<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="games-card {{ isset($hasAnimation) ? 'wow img-custom-anim-top' : '' }}" data-wow-duration="1s"
        data-wow-delay="0.{{ isset($hasAnimation) ? $loop->index : 0 }}s" style="position: relative; overflow: hidden;">
        
        {{-- Top Badge for Catalog/Product --}}
        @if ($listing->productCatalog)
            <div style="position: absolute; top: 10px; left: 10px; z-index: 10; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                🔥 {{ $listing->productCatalog->name }}
            </div>
        @endif
        
        <button class="fav-button {{ isWishlisted($listing->id) ? 'active' : '' }}" data-id="{{ $listing->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-heart-icon lucide-heart">
                <path
                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
            </svg>
        </button>
        <a href="{{ $listing->url }}" class="game-image">
            <img loading="lazy" src="{{ $listing->thumbnail_url }}" alt="{{ $listing->product_name }}">
        </a>
        
        {{-- Banner Section at Bottom --}}
        @if ($listing->selected_plan || $listing->delivery_method == 'auto')
            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 12px; text-align: center; z-index: 10;">
                <div style="color: white; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                    @if ($listing->selected_plan)
                        {{ $listing->selected_plan }}
                    @elseif ($listing->delivery_method == 'auto')
                        INSTANT DELIVERY
                    @endif
                </div>
            </div>
        @endif
        
        <div class="game-content">
            <div class="game-content-full">
                <h3 class="title">
                    <a href="{{ $listing->url }}">
                        {{ $listing->product_name }}
                    </a>
                </h3>
                
                {{-- Compact Info Badges --}}
                @if ($listing->selected_duration || ($listing->delivery_method && !($listing->selected_plan || $listing->delivery_method == 'auto')))
                    <div class="d-flex gap-1 flex-wrap mt-2 mb-2">
                        @if ($listing->selected_duration)
                            <span class="badge" style="background: #f59e0b; color: white; font-size: 10px; padding: 4px 8px; border-radius: 12px;">⏱️ {{ $listing->selected_duration }}</span>
                        @endif
                        @if ($listing->delivery_method && !($listing->selected_plan || $listing->delivery_method == 'auto'))
                            <span class="badge" style="background: #06b6d4; color: white; font-size: 10px; padding: 4px 8px; border-radius: 12px;">🚀 {{ ucfirst($listing->delivery_method) }}</span>
                        @endif
                    </div>
                @endif
                
                <p class="author" style="font-size: 12px; margin-bottom: 8px;">{{ __('By') }} <a
                        href="{{ route('seller.details', $listing->seller?->username ?? 404) }}">{{ $listing->seller?->username }}</a>
                </p>
                
                @if (!isset($isLatest))
                    <div class="star">
                        <div class="star-icon">
                            <iconify-icon icon="uis:favorite" class="star-icon"></iconify-icon>
                        </div>
                        <p>{{ number_format($listing->average_rating ?? 0, 1) }}
                            <span>({{ $listing->total_reviews ?? 0 }})</span>
                        </p>
                    </div>
                @endif
                <div class="pricing">
                    <div class="left">
                        @if ($listing->discount_amount > 0)
                            <h6 class="has-discount">
                                {{ setting('currency_symbol', 'global') }}{{ number_format($listing->price, 2) }}</h6>
                        @endif
                        <h6>{{ setting('currency_symbol', 'global') }}{{ number_format($listing->final_price, 2) }}
                        </h6>
                    </div>
                    <div class="right">
                        <p>{{ $listing->quantity }} {{ __('Offers') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if ($listing->is_trending)
            <div class="has-trending">
                <img src="{{ themeAsset('images/icon/flash-icon.png') }}" alt="{{ $listing->product_name }}">
            </div>
        @endif
    </div>
</div>
