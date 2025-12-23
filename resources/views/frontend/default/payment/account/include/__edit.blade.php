<!-- page modal start -->
<div class="custom-modal" id="withdrawEditAccount">
    <div class="common-modal-box">
        <div class="content">
            <div class="add-new-withdrawal">
                <div class="title-and-close">
                    <h4>{{ __('Update Payout Account') }}</h4>
                </div>
                <div class="add-forms">
                    <form action="" method="POST" enctype="multipart/form-data" id="edit-form">
                        @csrf
                        <div class="col-12 row manual-row gy-4 mt-0"></div>
                        <div class="modal-action-btn mt-4">
                            <button type="submit" class="primary-button">{{ __('Edit Withdraw Account') }}</button>
                            <button type="button" class="close withdraw-close">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page modal end -->
