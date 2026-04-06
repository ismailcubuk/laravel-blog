<footer class="front-footer">
    <style>
        .front-footer {
            margin-top: 2rem;
            border-top: 1px solid #e2e8f4;
            background: var(--front-surface);
            backdrop-filter: blur(6px);
            padding: 1.3rem 0;
        }

        .front-footer .social-icons {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.65rem;
        }

        .front-footer .social-icons li {
            margin: 0;
        }

        .front-footer .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            border-radius: 999px;
            border: 1px solid var(--front-border);
            background: var(--front-surface);
            padding: 0.35rem 0.82rem;
            color: var(--front-text);
            font-size: 0.82rem;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .front-footer .social-icons a:hover {
            color: var(--front-primary);
            border-color: var(--front-soft-border);
            text-decoration: none;
            transform: translateY(-1px);
        }

        .front-footer .copyright-text {
            text-align: center;
            margin-top: 0.95rem;
            color: var(--front-muted);
            font-size: 0.83rem;
            font-weight: 600;
        }

        .front-footer .copyright-text p {
            margin: 0;
        }

        .front-footer .copyright-text a {
            color: var(--front-primary);
            font-weight: 700;
        }
    </style>

    @php($currentYear = now()->year)

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="social-icons">
                    @if(!empty($settings['facebook_url']))
                        <li><a href="https://facebook.com/{{ ltrim($settings['facebook_url'], '@/') }}" target="_blank" rel="noopener">Facebook</a></li>
                    @endif
                    @if(!empty($settings['twitter_url']))
                        <li><a href="https://twitter.com/{{ ltrim($settings['twitter_url'], '@/') }}" target="_blank" rel="noopener">Twitter</a></li>
                    @endif
                    @if(!empty($settings['instagram_url']))
                        <li><a href="https://instagram.com/{{ ltrim($settings['instagram_url'], '@/') }}" target="_blank" rel="noopener">Instagram</a></li>
                    @endif
                    @if(!empty($settings['linkedin_url']))
                        <li><a href="https://linkedin.com/in/{{ ltrim($settings['linkedin_url'], '@/') }}" target="_blank" rel="noopener">LinkedIn</a></li>
                    @endif
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="copyright-text">
                    <p>{{ $settings['footer_text'] ?: 'Copyright ' . $currentYear . ' ' . ($settings['site_name'] ?? config('app.name')) }}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
