<?php

namespace Tests\Unit;

use App\Support\PostContentFormatter;
use PHPUnit\Framework\TestCase;

class PostContentFormatterTest extends TestCase
{
    public function test_it_formats_editor_markup(): void
    {
        $html = PostContentFormatter::toHtml(implode("\n\n", [
            '**kalin metin**',
            '*italik metin*',
            '`kod`',
            '[baglanti metni](http://127.0.0.1:8000/blog/create)',
            '[duzeltilen link](/http://127.0.0.1:8000/blog/create)',
            '[GIF: /https://example.com/sample.gif]',
            '- ilk madde' . "\n" . '- ikinci madde',
            '1. ilk sira' . "\n" . '2. ikinci sira',
            '> alinti metni',
            'emoji :)',
        ]));

        $this->assertStringContainsString('<strong>kalin metin</strong>', $html);
        $this->assertStringContainsString('<em>italik metin</em>', $html);
        $this->assertStringContainsString('<code>kod</code>', $html);
        $this->assertStringContainsString('<a href="http://127.0.0.1:8000/blog/create" target="_blank" rel="noopener noreferrer">baglanti metni</a>', $html);
        $this->assertStringContainsString('<a href="http://127.0.0.1:8000/blog/create" target="_blank" rel="noopener noreferrer">duzeltilen link</a>', $html);
        $this->assertStringContainsString('<span class="post-content-gif"><img src="https://example.com/sample.gif" alt="GIF" loading="lazy" decoding="async"></span>', $html);
        $this->assertStringContainsString('<ul><li>ilk madde</li><li>ikinci madde</li></ul>', $html);
        $this->assertStringContainsString('<ol><li>ilk sira</li><li>ikinci sira</li></ol>', $html);
        $this->assertStringContainsString('<blockquote>alinti metni</blockquote>', $html);
        $this->assertStringContainsString('emoji :)', $html);
    }

    public function test_it_escapes_html_before_formatting(): void
    {
        $html = PostContentFormatter::toHtml('<script>alert(1)</script> **guvenli**');

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $html);
        $this->assertStringContainsString('<strong>guvenli</strong>', $html);
    }
}
