@extends('frontend::layouts.user')
@section('title')
    {{ __('Badge') }}
@endsection
@push('css')
@endpush
@section('content')
    <div class="all-portfolios-box">
        @foreach ($portfolios as $portfolio)
            <div class="portfolio-box {{ in_array($portfolio->id, $userPortfolios ?? []) ? 'active' : '' }}">
                <div class="lock-content">
                    <div class="lock-icon">
                        <iconify-icon icon="material-symbols:lock" class="lock-icon"></iconify-icon>
                    </div>
                </div>
                @if ($user->portfolio_id == $portfolio->id)
                    <div class="check-icon-box">
                        <iconify-icon icon="material-symbols:check-circle" class="check-icon"></iconify-icon>
                    </div>
                @endif

                <div class="card-content">
                    <div class="img">
                        <img src="{{ asset($portfolio->icon) }}" alt="{{ $portfolio->name }}">
                    </div>
                    <div class="content">
                        <h4>{{ $portfolio->name }}</h4>
                        <p>{{ __('Level :level', ['level' => $portfolio->level]) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@push('js')
@endpush
