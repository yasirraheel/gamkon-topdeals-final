<div class="modal fade" id="deletePlan-{{ $plan->id }}" tabindex="-1" aria-labelledby="deletePlanLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table">
            <div class="modal-body popup-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="popup-body-text centered">
                    <div class="info-icon">
                        <i data-lucide="alert-triangle"></i>
                    </div>
                    <div class="title">
                        <h4>{{ __('Are you sure?') }}</h4>
                    </div>
                    <p>{{ __('You want to delete this plan') }} <strong>{{ $plan->plan_name }}</strong></p>
                    <form action="{{ route('admin.account-plans.delete', [$catalog->id, $plan->id]) }}" method="post">
                        @csrf
                        <div class="action-btns">
                            <button type="button" class="site-btn-sm danger-btn" data-bs-dismiss="modal">
                                <i data-lucide="x"></i>
                                {{ __('Close') }}
                            </button>
                            <button type="submit" class="site-btn-sm primary-btn">
                                <i data-lucide="check"></i>
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
