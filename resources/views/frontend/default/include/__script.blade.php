<script src="{{ themeAsset('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ themeAsset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ themeAsset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ themeAsset('js/magnific-popup.min.js') }}"></script>
<script src="{{ themeAsset('js/swiper.min.js') }}"></script>
<script src="{{ themeAsset('js/jarallax.min.js') }}"></script>
<script src="{{ themeAsset('js/iconify.min.js') }}"></script>
{{-- <script src="{{ themeAsset('js/moment.min.js') }}"> </script> --}}
<script src="{{ themeAsset('js/select2.js') }}"></script>
<script src="{{ themeAsset('js/flatpickr.js') }}"></script>
{{-- <script src="{{ themeAsset('js/cookie.js') }}"> </script> --}}
@if ((Route::is('seller.*') || Route::is('user.*')) && !Route::is('seller.details'))
    <script src="{{ themeAsset('js/dashboard-script.js') }}"></script>
@endif

@include('global.__t_notify')
@if (auth()->check())
    <script src="{{ asset('global/js/pusher.min.js') }}"></script>
    @include('global.__notification_script', ['for' => 'user', 'userId' => auth()->user()->id])
@endif

@stack('js')
@php
    $googleAnalytics = plugin_active('Google Analytics');
    $tawkChat = plugin_active('Tawk Chat');
    $fb = plugin_active('Facebook Messenger');
@endphp

@if ($googleAnalytics)
    @include('frontend::plugin.google_analytics', [
        'GoogleAnalyticsId' => json_decode($googleAnalytics?->data, true)['app_id'],
    ])
@endif
@if ($tawkChat)
    @include('frontend::plugin.tawk', ['data' => json_decode($tawkChat->data, true)])
@endif
@if ($fb)
    @include('frontend::plugin.fb', ['data' => json_decode($fb->data, true)])
@endif
@if (Route::is('seller.*') && !Route::is('seller.details'))
    <script src="{{ themeAsset('js/dashboard-tooltip-activation.js') }}"></script>
@else
    <script src="{{ themeAsset('js/theme-tooltip-activation.js') }}"></script>
@endif
<script>
    "use strict";

    // modal open and close functionality
    // bootstrap tooltip activation
    $(document).ready(function() {
        $('.logout-modal').on('click', function() {
            $('.common-modal-logout').addClass('open');
        });

        $('.common-modal-logout .cross').on('click', function() {
            $('.common-modal-logout').removeClass('open');
        });



        $(document).on('click', '.recent-search-remove-btn', function() {
            var sel = $(this)
            var value = $(this).data('value');
            $.ajax({
                url: "{{ route('remove.recent.search') }}",
                type: 'GET',
                data: {
                    value: value
                },
                success: function(response) {
                    if (response.success) {
                        $(sel).closest('.top-search-button').remove();
                    }
                }

            });
        })
        $(document).on('click', '.cookie-buttons', function() {
            $.ajax({
                url: "{{ route('cookies.gdpr.accept') }}",
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('.cookie.gdpr').remove();
                    }
                }

            });
        })

        function rejectSignupFirstOrderBonus() {
            $.ajax({
                url: "{{ route('cookies.signup.first.order.bonus.reject') }}",
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $(".subscribe-newsletter").addClass('hidden');
                    }
                }

            });
        }
        $(".close-btn#closePopupBtn").click(function() {
            rejectSignupFirstOrderBonus()
        });

        $(document).on('click', '.subscribe-newsletter', function(e) {
            if ($(e.target).hasClass('subscribe-newsletter') && !$(e.target).closest(
                    '.promo-popup-main').length) {
                if (!$(this).hasClass('hidden')) {
                    rejectSignupFirstOrderBonus();
                }
            }
        });
    });

    function removeUploadedFile(button) {
        var label = button.previousElementSibling.querySelector('label.file-ok');
        var input = button.previousElementSibling.querySelector('input[type="file"]');
        label.classList.remove('file-ok');
        label.removeAttribute('style');
        label.innerHTML = '<span>{{ __('Upload Image/Banner') }}</span>';
        input.value = ''; // Reset the input value
        button.style.display = 'none'; // Hide the close button
    }
    var hasAnimation = '{{ setting('site_animation', 'permission', 0) ? true : false }}';

    $(document).on('click', '.category-btn', function() {
        var categoryValue = $(this).data('category');
        var slug = $(this).data('slug');
        $('#headerSearchFormCategory').val(slug);
    })

    $(document).on('click', '.seller-favorite-btn', function(event) {

        event.preventDefault()
        var url = "{{ route('follow.seller', ':username') }}";
        url = url.replace(':username', $(this).data('username'));
        var button = $(this);
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    if (response.action == 'added') {
                        showNotification('success',
                            '{{ __('Now you are following this seller') }}');
                        button.addClass('active')
                        $('.wish').addClass('active')
                    } else {
                        button.removeClass('active')
                        showNotification('success',
                            '{{ __('Now you are not following this seller') }}');
                    }
                }
            },
            error: (error) => {

                if (error.status == 403) {
                    showNotification('error', '{{ __('You need to login to follow seller') }}');
                    return;
                }
                showNotification('error', 'Something went wrong!');
            }
        });
    })
    $(document).on('click', '.fav-button', function(event) {
        var button = $(this);
        event.preventDefault()
        $.ajax({
            url: "{{ route('addToWishlist') }}",
            type: 'GET',
            data: {
                wishlist: $(this).data('id')
            },
            success: function(response) {
                if (response.success) {
                    if (response.action == 'added') {
                        showNotification('success', 'Added to wishlist!');
                        button.addClass('active')
                    } else {
                        showNotification('success', 'Removed from wishlist!');
                        button.removeClass('active')
                    }
                } else {}
            },
            error: (error) => {
                showNotification('error', 'Something went wrong!');
            }
        });
    })
</script>
<script src="{{ themeAsset('js/main.js') }}"></script>
@stack('js_after')
