@extends('backend.layouts.app')
@section('title')
    {{ __('Create Ad Unit') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Create Ad Unit') }}</h2>
                            <a href="{{ route('admin.ad-units.index') }}" class="title-btn mx-2">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{ route('admin.ad-units.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="box-input" placeholder="e.g., Homepage Header" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Size / Dimension') }}</label>
                                            <input type="text" name="size" class="box-input" placeholder="e.g., 728x90" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Ad Unit Code') }}</label>
                                            <textarea name="code" class="form-textarea" rows="6" placeholder="Paste your ad code here" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label">{{ __('Status') }}</label>
                                            <div class="form-switch">
                                                <input type="hidden" name="is_active" value="0">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                                <label class="form-check-label">{{ __('Active') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <button type="submit" class="site-btn-sm primary-btn">{{ __('Create Ad Unit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
