<div class="alert-show-status">
    @if (session('notify'))
        @php
            $notification = session('notify');
            $alertClass = $notification['type'] == 'success' ? 'has-success' : 'has-danger';
            $alertTitle = $notification['title'];
            $iconSvg =
                $notification['type'] == 'success'
                    ? '<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="50" height="50" rx="25" fill="#00CC99" />
                    <path d="M22.0637 29.4036L34.7828 16.6832L36.7407 18.6398L22.0637 33.3168L13.2578 24.5109L15.2144 22.5543L22.0637 29.4036Z" fill="white" />
                </svg>'
                    : '<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="50" height="50" rx="25" fill="#E93A2D" />
                    <path d="M25 22.7781L32.7781 15L35 17.2219L27.2219 25L35 32.7781L32.7781 35L25 27.2219L17.2219 35L15 32.7781L22.7781 25L15 17.2219L17.2219 15L25 22.7781Z" fill="white" />
                </svg>';
        @endphp
        @php($randId = str()->random(5))
        <div class="td-alert-box {{ $alertClass }}" id="notification-{{ $randId }}">
            <div class="alert-content">
                <span class="alert-icon">{!! $iconSvg !!}</span>
                <div class="contents">
                    <h6 class="alert-title">{{ ucfirst($alertTitle) }}</h6>
                    <p class="alert-message">{{ ucfirst($notification['message']) }}</p>
                </div>
            </div>
            <button class="close-btn" data-id="{{ $randId }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                    fill="none">
                    <path
                        d="M10.0007 11.1667L5.91732 15.25C5.76454 15.4028 5.5701 15.4792 5.33398 15.4792C5.09787 15.4792 4.90343 15.4028 4.75065 15.25C4.59787 15.0972 4.52148 14.9028 4.52148 14.6667C4.52148 14.4306 4.59787 14.2361 4.75065 14.0833L8.83398 10L4.75065 5.91666C4.59787 5.76388 4.52148 5.56944 4.52148 5.33333C4.52148 5.09722 4.59787 4.90277 4.75065 4.74999C4.90343 4.59722 5.09787 4.52083 5.33398 4.52083C5.5701 4.52083 5.76454 4.59722 5.91732 4.74999L10.0007 8.83333L14.084 4.74999C14.2368 4.59722 14.4312 4.52083 14.6673 4.52083C14.9034 4.52083 15.0979 4.59722 15.2507 4.74999C15.4034 4.90277 15.4798 5.09722 15.4798 5.33333C15.4798 5.56944 15.4034 5.76388 15.2507 5.91666L11.1673 10L15.2507 14.0833C15.4034 14.2361 15.4798 14.4306 15.4798 14.6667C15.4798 14.9028 15.4034 15.0972 15.2507 15.25C15.0979 15.4028 14.9034 15.4792 14.6673 15.4792C14.4312 15.4792 14.2368 15.4028 14.084 15.25L10.0007 11.1667Z"
                        fill="#DC3545" />
                </svg>
            </button>
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="td-alert-box has-danger" id="notification-{{ $loop->index }}"
                style="margin-top: {{ $loop->index * 4 }}rem">
                <div class="alert-content">
                    <span class="alert-icon">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect width="50" height="50" rx="25" fill="#E93A2D" />
                            <path
                                d="M25 22.7781L32.7781 15L35 17.2219L27.2219 25L35 32.7781L32.7781 35L25 27.2219L17.2219 35L15 32.7781L22.7781 25L15 17.2219L17.2219 15L25 22.7781Z"
                                fill="white" />
                        </svg>
                    </span>
                    <div class="contents">
                        <h6 class="alert-title">{{ __('Validation Failed') }}</h6>
                        <p class="alert-message">{{ ucfirst($error) }}</p>
                    </div>
                </div>
                <button class="close-btn" data-id="{{ $loop->index }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                        fill="none">
                        <path
                            d="M10.0007 11.1667L5.91732 15.25C5.76454 15.4028 5.5701 15.4792 5.33398 15.4792C5.09787 15.4792 4.90343 15.4028 4.75065 15.25C4.59787 15.0972 4.52148 14.9028 4.52148 14.6667C4.52148 14.4306 4.59787 14.2361 4.75065 14.0833L8.83398 10L4.75065 5.91666C4.59787 5.76388 4.52148 5.56944 4.52148 5.33333C4.52148 5.09722 4.59787 4.90277 4.75065 4.74999C4.90343 4.59722 5.09787 4.52083 5.33398 4.52083C5.5701 4.52083 5.76454 4.59722 5.91732 4.74999L10.0007 8.83333L14.084 4.74999C14.2368 4.59722 14.4312 4.52083 14.6673 4.52083C14.9034 4.52083 15.0979 4.59722 15.2507 4.74999C15.4034 4.90277 15.4798 5.09722 15.4798 5.33333C15.4798 5.56944 15.4034 5.76388 15.2507 5.91666L11.1673 10L15.2507 14.0833C15.4034 14.2361 15.4798 14.4306 15.4798 14.6667C15.4798 14.9028 15.4034 15.0972 15.2507 15.25C15.0979 15.4028 14.9034 15.4792 14.6673 15.4792C14.4312 15.4792 14.2368 15.4028 14.084 15.25L10.0007 11.1667Z"
                            fill="#DC3545" />
                    </svg>
                </button>
            </div>
        @endforeach
    @endif
</div>

@push('js_after')
    <script>
        "use strict";
        $(document).ready(function() {
            setTimeout(function() {
                $('.td-alert-box').fadeOut('slow');
            }, 5000);

            $(document).on('click', '.td-alert-box .close-btn', function() {
                $(this).closest('.td-alert-box').hide()
            })
        });

        function showNotification(type, message, link = false) {
            var icon = type === 'success' ? 'fa-check-circle' : 'fa-triangle-exclamation';
            var alertClass = type === 'success' ? 'has-success' : 'has-danger';
            var alertTitle = type === 'success' ? 'Success' : 'Error';
            var randId = Date.now();
            var linkHtml = link ? `<a href="${link}" class="open-here">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="external-link" class="lucide lucide-external-link">
               <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
               <polyline points="15 3 21 3 21 9"></polyline>
               <line x1="10" x2="21" y1="14" y2="3"></line>
            </svg>
         </a>` : '';
            var iconSvg = [`<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="50" height="50" rx="25" fill="#00CC99" />
                    <path d="M22.0637 29.4036L34.7828 16.6832L36.7407 18.6398L22.0637 33.3168L13.2578 24.5109L15.2144 22.5543L22.0637 29.4036Z" fill="white" />
                </svg>`,
                `<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="50" height="50" rx="25" fill="#E93A2D" />
                    <path d="M25 22.7781L32.7781 15L35 17.2219L27.2219 25L35 32.7781L32.7781 35L25 27.2219L17.2219 35L15 32.7781L22.7781 25L15 17.2219L17.2219 15L25 22.7781Z" fill="white" />
                </svg>`
            ];
            var notificationHtml = `<div class="td-alert-box ${alertClass}" id="notification-${randId}">
            <div class="alert-content">
                <span class="alert-icon">${iconSvg[type === 'success' ? 0 : 1]}</span>
                <div class="contents">
                    <h6 class="alert-title">${(alertTitle)}</h6>
                    <p class="alert-message">${message.charAt(0).toUpperCase() + message.slice(1)}</p>
                </div>
            </div>
            <button class="close-btn" data-id="${randId}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                       d="M10.0007 11.1667L5.91732 15.25C5.76454 15.4028 5.5701 15.4792 5.33398 15.4792C5.09787 15.4792 4.90343 15.4028 4.75065 15.25C4.59787 15.0972 4.52148 14.9028 4.52148 14.6667C4.52148 14.4306 4.59787 14.2361 4.75065 14.0833L8.83398 10L4.75065 5.91666C4.59787 5.76388 4.52148 5.56944 4.52148 5.33333C4.52148 5.09722 4.59787 4.90277 4.75065 4.74999C4.90343 4.59722 5.09787 4.52083 5.33398 4.52083C5.5701 4.52083 5.76454 4.59722 5.91732 4.74999L10.0007 8.83333L14.084 4.74999C14.2368 4.59722 14.4312 4.52083 14.6673 4.52083C14.9034 4.52083 15.0979 4.59722 15.2507 4.74999C15.4034 4.90277 15.4798 5.09722 15.4798 5.33333C15.4798 5.56944 15.4034 5.76388 15.2507 5.91666L11.1673 10L15.2507 14.0833C15.4034 14.2361 15.4798 14.4306 15.4798 14.6667C15.4798 14.9028 15.4034 15.0972 15.2507 15.25C15.0979 15.4028 14.9034 15.4792 14.6673 15.4792C14.4312 15.4792 14.2368 15.4028 14.084 15.25L10.0007 11.1667Z"
                       fill="#DC3545" />
                 </svg>
            </button>
            ${linkHtml}
        </div>
`
            $('.alert-show-status').append(notificationHtml).show();
            $(`#notification-${randId}`).fadeOut(5000);
        }
    </script>
@endpush
