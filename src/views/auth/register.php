<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2024 The Tabler Authors
* Copyright 2018-2024 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>Sign up - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
        <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script>
        <meta name="msapplication-TileColor" content="#066fd1"/>
        <meta name="theme-color" content="#066fd1"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="mobile-web-app-capable" content="yes"/>
        <meta name="HandheldFriendly" content="True"/>
        <meta name="MobileOptimized" content="320"/>
        <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
        <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!"/>
        <meta name="canonical" content="https://tabler.io/demo/sign-up.html">
        <meta name="twitter:image:src" content="https://tabler.io/demo/static/og.png">
        <meta name="twitter:site" content="@tabler_ui">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
        <meta name="twitter:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
        <meta property="og:image" content="https://tabler.io/demo/static/og.png">
        <meta property="og:image:width" content="1280">
        <meta property="og:image:height" content="640">
        <meta property="og:site_name" content="Tabler">
        <meta property="og:type" content="object">
        <meta property="og:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
        <meta property="og:url" content="https://tabler.io/demo/static/og.png">
        <meta property="og:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
        <!-- CSS files -->
        <link href="public/css/tabler.min.css?1720208459" rel="stylesheet"/>
        <link href="public/css/tabler-flags.min.css?1720208459" rel="stylesheet"/>
        <link href="public/css/tabler-payments.min.css?1720208459" rel="stylesheet"/>
        <link href="public/css/tabler-vendors.min.css?1720208459" rel="stylesheet"/>
        <link href="public/css/demo.min.css?1720208459" rel="stylesheet"/>
        <style>
            @import url('https://rsms.me/inter/inter.css'); :root {
                --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            }

            body {
                font-feature-settings: "cv03", "cv04", "cv11";
            }
        </style>
    </head>
    <body class=" d-flex flex-column">
        <script src="public/js/demo-theme.min.js?1720208459"></script>
        <div class="page page-center">
            <div class="container container-tight py-4">
                
                <form action="/iods/register-user" method="POST">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Create new account</h2>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input"/>
                                <span class="form-check-label">
                                    Agree the <a href="./terms-of-service.html" tabindex="-1">terms and policy</a>
                                    .
                                </span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Create new account</button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-secondary mt-3">
                    Already have account? <a href="/iods/login" tabindex="-1">Sign in</a>
                </div>
            </div>
        </div>
        <!-- Libs JS -->
        <!-- Tabler Core -->
        <script src="public/js/tabler.min.js?1720208459" defer></script>
        <script src="public/js/demo.min.js?1720208459" defer></script>
    </body>
</html>
