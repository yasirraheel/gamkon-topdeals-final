@extends('backend.layouts.app')
@section('title')
    {{ __('Edit Account Plan') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Edit Account Plan') }} - {{ $catalog->name }}</h2>
                            <a href="{{ route('admin.account-plans.index', $catalog->id) }}" class="title-btn"><i
                                    data-lucide="arrow-left"></i>{{ __('Back') }}</a>
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
                            <form action="{{ route('admin.account-plans.update', [$catalog->id, $plan->id]) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Plan Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="plan_name" class="box-input mb-0" value="{{ old('plan_name', $plan->plan_name) }}"
                                                placeholder="{{ __('e.g., Pro, Ultra, Premium') }}" required />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Order') }}</label>
                                            <input type="number" name="order" class="box-input mb-0" value="{{ old('order', $plan->order) }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Status') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-active" name="status" value="1"
                                                    @checked(old('status', $plan->status) == 1) required />
                                                <label for="radio-active">{{ __('Active') }}</label>
                                                <input type="radio" id="radio-inactive" name="status" value="0"
                                                    @checked(old('status', $plan->status) == 0) required />
                                                <label for="radio-inactive">{{ __('Inactive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Description') }}</label>
                                            <textarea name="description" class="box-input mb-0" rows="4" placeholder="{{ __('Enter plan description (optional)') }}">{{ old('description', $plan->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="action-btns">
                                    <button type="submit" class="site-btn-sm primary-btn me-2">
                                        <i data-lucide="check"></i>
                                        {{ __('Update Plan') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
