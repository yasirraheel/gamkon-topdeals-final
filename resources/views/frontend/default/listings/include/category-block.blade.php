@push('css')
<style>
    .minimal-product-card {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .minimal-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }
    .wide-tooltip .tooltip-inner {
        max-width: 350px !important;
        width: 350px !important;
        text-align: left;
    }
</style>
@endpush

<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="minimal-product-card {{ isset($hasAnimation) ? 'wow img-custom-anim-top' : '' }}" data-wow-duration="1s"
        data-wow-delay="0.{{ isset($hasAnimation) ? $loop->index : 0 }}s" onclick="window.location.href='{{ $listing->url }}'">
        
        {{-- Duration Badge (Top Right) --}}
        @if($listing->selected_duration)
        <div data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Guarantee Period') }}: {{ $listing->selected_duration }}" style="position: absolute; top: 10px; right: 10px; background: #f3f4f6; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 4px; z-index: 5;">
            <iconify-icon icon="solar:shield-check-bold" style="color: #374151;"></iconify-icon>
            {{ $listing->selected_duration }}
        </div>
        @endif

        {{-- Top Section: Title & Image --}}
        <div style="display: flex; gap: 10px; margin-bottom: 10px; margin-top: 20px;">
            <div style="flex: 1;">
                <h5 data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="wide-tooltip" title="{{ $listing->product_name }}" style="font-size: 15px; font-weight: 700; color: #111; margin-bottom: 5px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $listing->product_name }}
                </h5>
                <div style="font-size: 12px; color: #666; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ Str::limit(strip_tags($listing->description), 50) }}
                </div>
            </div>
            <div style="width: 60px; height: 60px; flex-shrink: 0;">
                <img src="{{ $listing->thumbnail_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
        </div>

        {{-- Details Badges: Sharing, Plan, Devices --}}
        <div style="display: flex; gap: 6px; margin-bottom: 12px; flex-wrap: wrap;">
            @if($listing->selected_plan)
            <div data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Sharing Method') }}: {{ $listing->selected_plan }}" 
                 style="background: #eff6ff; color: #3b82f6; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                <iconify-icon icon="solar:user-bold"></iconify-icon>
                {{ $listing->selected_plan }}
            </div>
            @endif

            @if($listing->plan_id)
            <div data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Plan') }}: {{ $listing->plan_id }}" 
                 style="background: #f0fdf4; color: #16a34a; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                <iconify-icon icon="solar:star-bold"></iconify-icon>
                {{ $listing->plan_id }}
            </div>
            @endif

            @if($listing->devices)
            <div data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Supported Devices') }}: {{ $listing->devices }}" 
                 style="background: #f3f4f6; color: #4b5563; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                <iconify-icon icon="solar:devices-bold"></iconify-icon>
                {{ Str::limit($listing->devices, 10) }}
            </div>
            @endif
        </div>

        {{-- Middle Section: Seller & Rating --}}
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px dashed #eee;">
            {{-- Seller --}}
            <div style="display: flex; align-items: center; gap: 6px;">
                <img src="{{ $listing->seller->avatar_path }}" style="width: 20px; height: 20px; border-radius: 50%; object-fit: cover;">
                <span style="font-size: 12px; font-weight: 600; color: #333; text-transform: uppercase;">{{ $listing->seller->username }}</span>
            </div>
            
            {{-- Rating --}}
            <div style="display: flex; align-items: center; gap: 4px;">
                @if($listing->avg_rating > 0)
                    <iconify-icon icon="solar:like-bold" style="color: #3b82f6; font-size: 16px;"></iconify-icon>
                    <span style="color: #3b82f6; font-weight: 700; font-size: 13px;">{{ number_format($listing->avg_rating * 20, 2) }}%</span>
                    <span style="color: #999; font-size: 11px;">({{ $listing->reviews()->count() }})</span>
                @else
                    <span style="color: #999; font-size: 11px;">{{ __('No rating') }}</span>
                @endif
            </div>
        </div>

        {{-- Bottom Section: Price & Delivery --}}
        <div style="display: flex; align-items: center; justify-content: space-between;">
            {{-- Price --}}
            <div style="font-size: 18px; font-weight: 800; color: #ef4444;">
                {{ amountWithCurrency($listing->final_price) }}
            </div>

            {{-- Delivery --}}
            <div data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Delivery Time') }}" style="display: flex; align-items: center; gap: 4px; color: #888; font-size: 12px;">
                <iconify-icon icon="solar:clock-circle-linear" style="font-size: 16px;"></iconify-icon>
                <span>
                    @if($listing->delivery_method == 'auto')
                        {{ __('Instant') }}
                    @elseif($listing->delivery_speed)
                        {{ $listing->delivery_speed }} {{ $listing->delivery_speed_unit }}
                    @else
                        {{ __('Manual') }}
                    @endif
                </span>
            </div>
        </div>

    </div>
</div>
