<footer class="front-footer">
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/partials-footer.css') }}">
@endpush

    @php($currentYear = now()->year)
    @php(
        $socialHref = function (?string $raw, string $platform): ?string {
            $raw = trim((string) $raw);
            if ($raw === '' || $raw === '#') {
                return null;
            }

            if (preg_match('/^https?:\/\//i', $raw)) {
                return $raw;
            }

            $raw = preg_replace('/^@+/', '', $raw);
            $raw = trim((string) $raw, "/ \t\n\r\0\x0B");
            if ($raw === '') {
                return null;
            }

            if (str_contains($raw, '.')) {
                return 'https://' . $raw;
            }

            return match ($platform) {
                'facebook' => 'https://facebook.com/' . $raw,
                'twitter' => 'https://x.com/' . $raw,
                'instagram' => 'https://instagram.com/' . $raw,
                'linkedin' => 'https://linkedin.com/in/' . $raw,
                default => null,
            };
        }
    )
    @php($facebookHref = $socialHref($settings['facebook_url'] ?? null, 'facebook'))
    @php($twitterHref = $socialHref($settings['twitter_url'] ?? null, 'twitter'))
    @php($instagramHref = $socialHref($settings['instagram_url'] ?? null, 'instagram'))
    @php($linkedinHref = $socialHref($settings['linkedin_url'] ?? null, 'linkedin'))
    @php(
        $socialItems = array_values(array_filter([
            ['label' => 'Facebook', 'href' => $facebookHref, 'icon' => 'facebook'],
            ['label' => 'Twitter', 'href' => $twitterHref, 'icon' => 'twitter'],
            ['label' => 'Instagram', 'href' => $instagramHref, 'icon' => 'instagram'],
            ['label' => 'LinkedIn', 'href' => $linkedinHref, 'icon' => 'linkedin'],
        ], fn ($item) => !empty($item['href'])))
    )

    <div class="container">
        <div class="footer-wrap">
            @if(count($socialItems) > 0)
                <ul class="social-icons">
                    @foreach($socialItems as $item)
                        @if(!$loop->first)
                        @endif
                        <li>
                            <a href="{{ $item['href'] }}" target="_blank" rel="noopener" aria-label="{{ $item['label'] }}">
                                <i class="fa fa-{{ $item['icon'] }}"></i>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="copyright-text">
                <p>{{ $settings['footer_text'] ?: 'Copyright ' . $currentYear . ' ' . ($settings['site_name'] ?? config('app.name')) }}</p>
            </div>
        </div>
    </div>
</footer>


