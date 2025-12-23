<div class="notification-list">
    @php
        $iconColorMap = [
            'check-circle' => 'success',
            'wallet' => 'primary',
            'newspaper' => 'info',
            'user-plus' => 'primary',
            'message-circle' => 'info',
            'shopping-cart' => 'primary',
            'package' => 'pending',
            'gift' => 'success',
        ];
    @endphp
    @foreach ($latestNotifications as $notification)
        <a href="{{ buyerSellerRoute('read-notification', $notification->id) }}"
            class="list {{ $iconColorMap[$notification->icon] ?? 'info' }} {{ $notification->read ? '' : 'active' }}">
            <div class="list-item">
                <div class="icon">
                    @if ($notification->icon == 'check-circle')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 1024 1024">
                            <path fill="#fff"
                                d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0m0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01m204.336-636.352L415.935 626.944l-135.28-135.28c-12.496-12.496-32.752-12.496-45.264 0c-12.496 12.496-12.496 32.752 0 45.248l158.384 158.4c12.496 12.48 32.752 12.48 45.264 0c1.44-1.44 2.673-3.009 3.793-4.64l318.784-320.753c12.48-12.496 12.48-32.752 0-45.263c-12.512-12.496-32.768-12.496-45.28 0" />
                        </svg>
                    @elseif ($notification->icon == 'wallet')
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            fill="none">
                            <path
                                d="M4.125 4.125C2.60622 4.125 1.375 5.35622 1.375 6.875V8.25H20.625V6.875C20.625 5.35622 19.3938 4.125 17.875 4.125H4.125Z"
                                fill="white"></path>
                            <path
                                d="M1.375 15.125V9.625H20.625V15.125C20.625 16.6438 19.3938 17.875 17.875 17.875H4.125C2.60622 17.875 1.375 16.6438 1.375 15.125ZM14.4375 13.75C14.0579 13.75 13.75 14.0579 13.75 14.4375C13.75 14.8171 14.0579 15.125 14.4375 15.125H17.1875C17.5671 15.125 17.875 14.8171 17.875 14.4375C17.875 14.0579 17.5671 13.75 17.1875 13.75H14.4375Z"
                                fill="white"></path>
                        </svg>
                    @elseif ($notification->icon == 'newspaper')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 32 32">
                            <g fill="#fff">
                                <path
                                    d="M6 10a1 1 0 0 0 0 2h18a1 1 0 1 0 0-2zm-.5 4a.5.5 0 0 0 0 1h19a.5.5 0 1 0 0-1zM19 17.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h5a.5.5 0 1 0 0-1zm-.5 3.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h5a.5.5 0 1 0 0-1zM5 19a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2z" />
                                <path
                                    d="M8 4a2 2 0 0 0-2 2H3.962C2.252 6 1 7.418 1 9v18c0 2.134 1.683 4 3.923 4h24.094A2 2 0 0 0 31 29V6a2 2 0 0 0-2-2zm18.04 4a.97.97 0 0 1 .939.786q.021.103.022.214v18a2 2 0 0 0 2 2H4.923C3.861 29 3 28.105 3 27V9c0-.552.43-1 .962-1z" />
                            </g>
                        </svg>
                    @elseif ($notification->icon == 'user-plus')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.25" height="1" viewBox="0 0 640 512">
                            <path fill="#fff"
                                d="M96 128a128 128 0 1 1 256 0a128 128 0 1 1-256 0M0 482.3C0 383.8 79.8 304 178.3 304h91.4c98.5 0 178.3 79.8 178.3 178.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3M504 312v-64h-64c-13.3 0-24-10.7-24-24s10.7-24 24-24h64v-64c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24h-64v64c0 13.3-10.7 24-24 24s-24-10.7-24-24" />
                        </svg>
                    @elseif ($notification->icon == 'message-circle')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 24 24">
                            <path fill="#fff"
                                d="M19.07 4.93a10 10 0 0 0-16.28 11a1.06 1.06 0 0 1 .09.64L2 20.8a1 1 0 0 0 .27.91A1 1 0 0 0 3 22h.2l4.28-.86a1.26 1.26 0 0 1 .64.09a10 10 0 0 0 11-16.28ZM8 13a1 1 0 1 1 1-1a1 1 0 0 1-1 1m4 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1m4 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1" />
                        </svg>
                    @elseif ($notification->icon == 'check-circle')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 24 24">
                            <path fill="#fff"
                                d="M11 14v8H7a3 3 0 0 1-3-3v-4a1 1 0 0 1 1-1zm8 0a1 1 0 0 1 1 1v4a3 3 0 0 1-3 3h-4v-8zM16.5 2a3.5 3.5 0 0 1 3.163 5H20a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-7V7h-2v5H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h.337A3.5 3.5 0 0 1 4 5.5C4 3.567 5.567 2 7.483 2c1.755-.03 3.312 1.092 4.381 2.934l.136.243c1.033-1.914 2.56-3.114 4.291-3.175zm-9 2a1.5 1.5 0 0 0 0 3h3.143C9.902 5.095 8.694 3.98 7.5 4m8.983 0c-1.18-.02-2.385 1.096-3.126 3H16.5a1.5 1.5 0 1 0-.017-3" />
                        </svg>
                    @elseif ($notification->icon == 'shopping-cart')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 24 24">
                            <path fill="#fff"
                                d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2s-.9-2-2-2M1 2v2h2l3.6 7.59l-1.35 2.45c-.16.28-.25.61-.25.96c0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12l.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2s2-.9 2-2s-.9-2-2-2" />
                        </svg>
                    @elseif ($notification->icon == 'package')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 24 24">
                            <path fill="#fff"
                                d="M5.12 5h13.75l-.94-1h-12zm15.42.23c.29.34.46.77.46 1.27V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6.5c0-.5.17-.93.46-1.27l1.38-1.68C5.12 3.21 5.53 3 6 3h12c.47 0 .88.21 1.15.55zM6 18h6v-3H6z" />
                        </svg>
                    @elseif ($notification->icon == 'gift')
                        <svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 24 24">
                            <path fill="#fff"
                                d="M11 14v8H7a3 3 0 0 1-3-3v-4a1 1 0 0 1 1-1zm8 0a1 1 0 0 1 1 1v4a3 3 0 0 1-3 3h-4v-8zM16.5 2a3.5 3.5 0 0 1 3.163 5H20a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-7V7h-2v5H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h.337A3.5 3.5 0 0 1 4 5.5C4 3.567 5.567 2 7.483 2c1.755-.03 3.312 1.092 4.381 2.934l.136.243c1.033-1.914 2.56-3.114 4.291-3.175zm-9 2a1.5 1.5 0 0 0 0 3h3.143C9.902 5.095 8.694 3.98 7.5 4m8.983 0c-1.18-.02-2.385 1.096-3.126 3H16.5a1.5 1.5 0 1 0-.017-3" />
                        </svg>
                    @endif
                </div>
                <div class="texts">
                    <h3>{{ $notification->title }}</h3>
                    <p class="truncateText2">{{ $notification->description }}</p>
                </div>
            </div>
            @php($time = str($notification->created_at->diffForHumans())->remove(' ago'))
            <p>{{ str($time)->before(' ') . ' ' . str($time)->after(' ')->charAt(0) }}</p>
        </a>
    @endforeach
</div>
