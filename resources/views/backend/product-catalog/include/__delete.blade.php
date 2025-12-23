<div class="modal fade" id="deleteCatalog-{{ $catalog->id }}" tabindex="-1" aria-labelledby="editReviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table">
            <div class="modal-body popup-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="popup-body-text centered">
                    <div class="icon-box">
                        <i data-lucide="trash-2"></i>
                    </div>
                    <h3 class="title">{{ __('Are you sure?') }}</h3>
                    <p>{{ __('You want to delete') }} <strong>{{ $catalog->name }}</strong></p>
                    <form action="{{ route('admin.product-catalog.delete', $catalog->id) }}" method="post">
                        @csrf
                        <div class="action-btns">
                            <button type="submit" class="site-btn danger-btn">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
