<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/img/favicon-2.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        :root {
            --font-family: "DM Sans", sans-serif;
            --primary-color: {{ setting('primary_color', 'global') }};
            --secondary-color: #303030;
            --text-color: rgba(48, 48, 48, 0.80);
            --text-white: #fff;
            font-size: 16px;
        }

        body {
            margin: 0;
            font-family: var(--font-family);
            background-color: #fff;
            color: rgba(48, 48, 48, 0.80);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
            line-height: 1.2;
            margin-bottom: 0;
            word-break: break-word;
            font-weight: 500;
            color: var(--text-color);
        }

        .email-container {
            max-width: 40rem;
            /* 640px */
            margin: 50px auto;
            /* 40px */
            background: var(--bg-color);
        }

        .email-container-box {
            padding: 0 48px 48px 48px;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }

        .banner {
            border-radius: 12px;
            background: #FFF;
            box-shadow: 0px 4px 30px 0px rgba(0, 0, 0, 0.10);
        }

        .banner .thumb img {
            width: 100%;
            border-radius: 8px 8px 0 0;
        }

        .banner .content {
            padding: 40px;
        }

        .banner .content h1 {
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 1.5rem;
            line-height: normal;
            color: var(--secondary-color);
        }

        .banner .content h1 a {
            display: inline-block;
            color: var(--primary-color);
        }

        .banner .content p {
            margin: 20px 0;
            /* 20px */
            font-size: 16px;
            /* 16px */
            line-height: 28px;
            /* 28px */
            font-weight: 400;
        }

        .feature h4 {
            color: var(--secondary-color);
            font-size: clamp(1.125rem, 4vw, 1.25rem);
            font-weight: 600;
            line-height: 32px;
        }

        .feature ul li {
            color: var(--text-color);
            font-size: 14px;
            font-weight: 600;
            line-height: 26px;
            margin-bottom: 4px;
        }

        .feature ul li:last-child {
            margin-bottom: 0;
        }

        .cta-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        .btn-primary {
            display: flex;
            height: 52px;
            padding: 12px 32px;
            justify-content: center;
            align-items: center;
            gap: 3px;
            border-radius: 12px;
            background: var(--primary-color);
            box-shadow: 0px 1px 4px 0px rgba(25, 33, 61, 0.08);
            color: #FFF;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            line-height: normal;
            border: none;
        }

        .footer {
            padding: 40px 48px 16px 48px;
        }

        .footer .top .social-icons {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 45px;
        }

        .footer .top .social-icons h3 {
            color: var(--secondary-color);
            font-size: 20px;
            font-weight: 600;
            line-height: normal;
            margin-bottom: 16px;
        }

        .footer .top .social-icons .icons {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .footer .top .social-icons .icons a svg path {
            fill: #30303099;
        }

        .footer .top .social-icons .icons a:hover svg path {
            fill: var(--primary-color);
        }

        .footer .links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .footer .links a {
            color: var(--secondary-color);
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            text-decoration-line: underline;
            text-decoration-style: solid;
            text-decoration-skip-ink: none;
            text-decoration-thickness: auto;
            text-underline-offset: auto;
        }

        .footer .links a:hover {
            color: var(--text-white);
        }

        .footer .copyright p {
            color: var(--secondary-color);
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            line-height: 24px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .banner .content h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 576px) {
            .banner .content h1 {
                font-size: 20px;
            }

            .footer .links a {
                font-size: 14px;
            }

            .footer .copyright p {
                font-size: 12px;
            }

            .email-container {
                margin: 1.5rem auto;
            }

            .email-container-box {
                padding: 0 25px 25px 25px;
            }

            .banner .content {
                padding: 1rem;
            }

            .header {
                margin-bottom: 16px;
            }

            .banner .content p {
                margin: 10px 0;
                font-size: 14px;
                line-height: 24px;
            }

            .feature ul li {
                font-size: 14px;
                font-weight: 500;
                line-height: 24px;
            }

            .banner .content h1 {
                margin-bottom: 0.625rem;
            }

            .cta-btn {
                margin-top: 26px;
            }

            .btn-primary {
                height: 40px;
                padding: 10px 22px;
            }

            .footer {
                padding: 16px 16px 16px 16px;
            }

            .footer .top .social-icons {
                margin-bottom: 20px;
            }

            .footer .links {
                gap: 10px;
            }
        }

        .content-footer {
            margin-top: 20px;
        }
    </style>

</head>

<body>
    <div class="email-container">
        <div class="email-container-box">
            <!-- Header Section -->
            <div class="header">
                <div class="logo">
                    <a href="{{ $details['site_link'] }}">
                        <img src="{{ $details['site_logo'] }}" alt="Logo">
                    </a>
                </div>
            </div>

            <!-- Banner Section -->
            <div class="banner">
                <div class="thumb">
                    <img src="{{ $details['banner'] }}" alt="Banner">
                </div>
                <div class="content">
                    <h1>{{ $details['title'] }}</h1>
                    <p>{{ $details['salutation'] }}</p>
                    <p>{!! $details['message_body'] !!}</p>
                    <div class="cta-btn">
                        <a href="{{ $details['button_link'] }}" class="btn-primary">{{ $details['button_level'] }}</a>
                    </div>
                    @if ($details['footer_status'])
                        <div class="content-footer">
                            <p>{!! $details['footer_body'] !!}</p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Footer Section -->
            <div class="footer">
                <div class="top">
                    <div class="social-icons">
                        <h3>Stay in touch</h3>
                        <div class="icons">
                            @foreach (\App\Models\Social::all() as $social)
                                <a href="{{ url($social->url) }}"><i class="{{ $social->class_name }}"></i>
                                    {{ $social->icon_name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- <div class="links">
                    <a href="{{ route('page.privacy') }}">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookies Settings</a>
                </div> --}}
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} {{ setting('site_title', 'global') }}.
                        {{ __('All rights reserved') }}.</p>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
