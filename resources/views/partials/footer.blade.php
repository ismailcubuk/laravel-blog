<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                 <ul class="social-icons">
                    <li>
                        <a href="https://facebook.com/{{ $settings['facebook_url'] }}" target="_blank">Facebook</a>
                    </li>
                    <li>
                        <a href="https://twitter.com/{{ $settings['twitter_url'] }}" target="_blank">Twitter</a>
                    </li>
                    <li>
                        <a href="https://instagram.com/{{ $settings['instagram_url'] }}" target="_blank">Instagram</a>
                    </li>
                    <li>
                        <a href="https://linkedin.com/in/{{ $settings['linkedin_url'] }}" target="_blank">Linkedin</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="copyright-text">
                    <p>{{ $settings['footer_text'] ?: '© 2026 ' . $settings['site_name'] }} | Design: 
                        <a rel="nofollow" href="https://github.com/ismailcubuk" target="_parent">İsmail Cubuk</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>