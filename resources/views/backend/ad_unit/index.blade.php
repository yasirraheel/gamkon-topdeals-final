@extends('backend.layouts.app')
@section('title')
    {{ __('Ad Management') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Ad Management') }}</h2>
                            <a href="{{ route('admin.ad-units.create') }}" class="title-btn"><i
                                    data-lucide="plus-circle"></i>{{ __('Add Ad Unit') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Global Settings Section -->
            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Global Ad Settings') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.ad-units.settings.update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Header Code') }} <small>({{ __('Inside <head> tag') }})</small></label>
                                            <textarea name="ads_head_code" class="form-textarea" rows="4" placeholder="<script>...</script>">{{ \App\Models\Setting::where('name', 'ads_head_code')->value('val') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Body Code') }} <small>({{ __('Inside <body> tag') }})</small></label>
                                            <textarea name="ads_body_code" class="form-textarea" rows="4" placeholder="<script>...</script>">{{ \App\Models\Setting::where('name', 'ads_body_code')->value('val') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Settings') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ad Units List Section -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Ad Units') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Size') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($adUnits as $adUnit)
                                            <tr>
                                                <td><strong>{{ $adUnit->name }}</strong></td>
                                                <td>{{ $adUnit->size }}</td>
                                                <td>
                                                    @if ($adUnit->is_active)
                                                        <div class="site-badge success">{{ __('Active') }}</div>
                                                    @else
                                                        <div class="site-badge danger">{{ __('Inactive') }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.ad-units.edit', $adUnit->id) }}"
                                                        class="round-icon-btn primary-btn" data-bs-toggle="tooltip"
                                                        title="{{ __('Edit Ad Unit') }}">
                                                        <i data-lucide="edit-3"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('admin.ad-units.destroy', $adUnit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="{{ __('Delete Ad Unit') }}">
                                                            <i data-lucide="trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">{{ __('No Ad Units Found!') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $adUnits->links('backend.include.__pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
