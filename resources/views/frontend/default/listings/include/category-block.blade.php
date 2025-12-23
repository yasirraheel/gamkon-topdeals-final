<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="games-card {{ isset($hasAnimation) ? 'wow img-custom-anim-top' : '' }}" data-wow-duration="1s"
        data-wow-delay="0.{{ isset($hasAnimation) ? $loop->index : 0 }}s" style="position: relative; overflow: hidden; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        
        {{-- Top Badge for Catalog/Product --}}
        @if ($listing->productCatalog)
            <div style="position: absolute; top: 12px; left: 12px; z-index: 10; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 7px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3); text-transform: uppercase; letter-spacing: 0.5px;">
                🔥 {{ $listing->productCatalog->name }}
            </div>
        @endif
        
        {{-- Category Badge --}}
        <div style="position: absolute; top: 12px; right: 12px; z-index: 10; background: rgba(0,0,0,0.7); backdrop-filter: blur(10px); color: white; padding: 6px 12px; border-radius: 16px; font-size: 10px; font-weight: 600; border: 1px solid rgba(255,255,255,0.2);">
            📁 {{ $listing->category->name }}
        </div>
        
        <button class="fav-button {{ isWishlisted($listing->id) ? 'active' : '' }}" data-id="{{ $listing->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-heart-icon lucide-heart">
                <path
                    d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
            </svg>
        </button>
        <a href="{{ $listing->url }}" class="game-image" style="position: relative; display: block;">
            <img loading="lazy" src="{{ $listing->thumbnail_url }}" alt="{{ $listing->product_name }}">
            
            {{-- Product Name Overlay on Image --}}
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%; z-index: 8; text-align: center;">
                <div style="background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); padding: 15px 20px; border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.18);">
                    <h3 style="color: white; font-size: 18px; font-weight: 800; margin: 0; line-height: 1.3; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5); letter-spacing: 0.3px;">
                        {{ $listing->product_name }}
                    </h3>
                </div>
            </div>
        </a>
        
        {{-- Plan/Delivery Banner with Wave Effect --}}
        @if ($listing->selected_plan || $listing->delivery_method == 'auto')
            <div style="position: absolute; bottom: 0; left: 0; right: 0; z-index: 10;">
                {{-- Wave SVG --}}
                <svg style="display: block; width: 100%; height: 40px;" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="waveGradient{{ $listing->id }}" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#dc2626;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#b91c1c;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path d="M0,0 C150,50 350,0 600,40 C850,80 1050,30 1200,60 L1200,120 L0,120 Z" fill="url(#waveGradient{{ $listing->id }})"></path>
                </svg>
                <div style="background: linear-gradient(135deg, #b91c1c 0%, #dc2626 50%, #ef4444 100%); padding: 10px 15px 15px; margin-top: -2px; text-align: center;">
                    <div style="color: white; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        @if ($listing->selected_plan)
                            ⭐ {{ $listing->selected_plan }}
                        @elseif ($listing->delivery_method == 'auto')
                            ⚡ INSTANT DELIVERY
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <div class="game-content" style="padding-bottom: {{ ($listing->selected_plan || $listing->delivery_method == 'auto') ? '80px' : '15px' }};">
            <div class="game-content-full">
                {{-- Prominent Attributes Grid --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px;">
                    @if ($listing->selected_duration)
                        <div style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; padding: 6px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; text-align: center; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);">
                            ⏱️ {{ $listing->selected_duration }}
                        </div>
                    @endif
                    
                    @if ($listing->delivery_method && $listing->delivery_method != 'auto')
                        <div style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; padding: 6px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; text-align: center; box-shadow: 0 2px 6px rgba(6, 182, 212, 0.3);">
                            🚀 {{ ucfirst($listing->delivery_method) }}
                        </div>
                    @endif
                    
                    @if ($listing->delivery_method == 'manual' && $listing->delivery_speed)
                        <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; padding: 6px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; text-align: center; box-shadow: 0 2px 6px rgba(139, 92, 246, 0.3);">
                            ⚡ {{ $listing->delivery_speed }} {{ $listing->delivery_speed_unit }}
                        </div>
                    @endif
                    
                    @if ($listing->quantity > 0)
                        <div style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; padding: 6px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; text-align: center; box-shadow: 0 2px 6px rgba(236, 72, 153, 0.3);">
                            📦 {{ $listing->quantity }} {{ __('Offers') }}
                        </div>
                    @endif
                </div>
                
                <p class="author" style="font-size: 12px; margin-bottom: 8px; color: #6b7280; font-weight: 500;">
                    👤 {{ __('By') }} <a href="{{ route('seller.details', $listing->seller?->username ?? 404) }}" style="color: #3b82f6; font-weight: 600;">{{ $listing->seller?->username }}</a>
                </p>
                
                @if (!isset($isLatest))
                    <div class="star" style="margin-bottom: 10px;">
                        <div class="star-icon">
                            <iconify-icon icon="uis:favorite" class="star-icon"></iconify-icon>
                        </div>
                        <p style="font-weight: 600;">{{ number_format($listing->average_rating ?? 0, 1) }}
                            <span style="color: #9ca3af;">({{ $listing->total_reviews ?? 0 }})</span>
                        </p>
                    </div>
                @endif
                
                <div class="pricing" style="margin-top: 12px;">
                    <div class="left">
                        @if ($listing->discount_amount > 0)
                            <h6 class="has-discount" style="font-size: 13px; text-decoration: line-through; color: #9ca3af;">
                                {{ setting('currency_symbol', 'global') }}{{ number_format($listing->price, 2) }}</h6>
                        @endif
                        <h6 style="font-size: 20px; font-weight: 800; color: #10b981;">{{ setting('currency_symbol', 'global') }}{{ number_format($listing->final_price, 2) }}
                        </h6>
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
