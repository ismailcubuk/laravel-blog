<?php

namespace App\Support;

class PostContentFormatter
{
    public static function toHtml(?string $content): string
    {
        $content = trim(str_replace(["\r\n", "\r"], "\n", (string) $content));

        if ($content === '') {
            return '';
        }

        $blocks = preg_split("/\n{2,}/", e($content)) ?: [];

        return collect($blocks)
            ->map(fn (string $block) => self::formatBlock($block))
            ->filter()
            ->implode("\n");
    }

    private static function formatBlock(string $block): string
    {
        $lines = array_values(array_filter(explode("\n", $block), fn (string $line) => trim($line) !== ''));

        if ($lines === []) {
            return '';
        }

        if (self::allLinesMatch($lines, '/^&gt;\s*/')) {
            $content = collect($lines)
                ->map(fn (string $line) => preg_replace('/^&gt;\s*/', '', $line))
                ->map(fn (string $line) => self::formatInline((string) $line))
                ->implode('<br>');

            return '<blockquote>' . $content . '</blockquote>';
        }

        if (self::allLinesMatch($lines, '/^-\s+/')) {
            $items = collect($lines)
                ->map(fn (string $line) => '<li>' . self::formatInline((string) preg_replace('/^-\s+/', '', $line)) . '</li>')
                ->implode('');

            return '<ul>' . $items . '</ul>';
        }

        if (self::allLinesMatch($lines, '/^\d+\.\s+/')) {
            $items = collect($lines)
                ->map(fn (string $line) => '<li>' . self::formatInline((string) preg_replace('/^\d+\.\s+/', '', $line)) . '</li>')
                ->implode('');

            return '<ol>' . $items . '</ol>';
        }

        return '<p>' . collect($lines)->map(fn (string $line) => self::formatInline($line))->implode('<br>') . '</p>';
    }

    private static function formatInline(string $text): string
    {
        $codeSnippets = [];

        $text = preg_replace_callback('/`([^`\n]+)`/', function (array $matches) use (&$codeSnippets) {
            $key = '%%CODE' . count($codeSnippets) . '%%';
            $codeSnippets[$key] = '<code>' . $matches[1] . '</code>';

            return $key;
        }, $text);

        $text = preg_replace_callback('/\[GIF:\s*(\/?https?:\/\/[^\]\s]+)\]/i', function (array $matches) {
            $src = preg_replace('/^\/(https?:\/\/)/', '$1', $matches[1]);

            return '<span class="post-content-gif"><img src="' . $src . '" alt="GIF" loading="lazy" decoding="async"></span>';
        }, $text);

        $text = preg_replace_callback('/\[([^\]\n]+)\]\((\/?https?:\/\/[^)\s]+|\/[^)\s]+|#[^)\s]+)\)/', function (array $matches) {
            $href = preg_replace('/^\/(https?:\/\/)/', '$1', $matches[2]);
            $externalAttributes = preg_match('/^https?:\/\//', (string) $href) ? ' target="_blank" rel="noopener noreferrer"' : '';

            return '<a href="' . $href . '"' . $externalAttributes . '>' . $matches[1] . '</a>';
        }, $text);

        $text = preg_replace('/\*\*([^*\n]+)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/(?<!\*)\*([^*\n]+)\*(?!\*)/', '<em>$1</em>', $text);

        return strtr($text, $codeSnippets);
    }

    private static function allLinesMatch(array $lines, string $pattern): bool
    {
        foreach ($lines as $line) {
            if (!preg_match($pattern, $line)) {
                return false;
            }
        }

        return true;
    }
}
