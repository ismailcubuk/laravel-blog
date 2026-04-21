<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{

    // ================= ABOUT PAGE =================

    public function about()
    {

        $page = Page::firstOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'description' => 'ABOUT US',
                'hero_image' => '/assets/images/about-us.jpg'
            ]
        );

        $sections = PageSection::where('page_id', $page->id)
            ->orderBy('section_order')
            ->orderBy('column_index')
            ->get()
            ->groupBy('section_order');

        return view('admin.pages.about', compact('page', 'sections'));
    }


    public function updateAbout(Request $request)
    {

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sections' => 'nullable|array'
        ]);


        $page = Page::firstOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'description' => '',
                'hero_image' => null
            ]
        );


        // HERO IMAGE
        if ($request->hasFile('hero_image'))
        {
            $this->deleteStorageAsset($page->hero_image);
            $page->hero_image = $this->storePublicUpload($request->file('hero_image'));
        }


        // BASIC DATA
        $page->title = $request->title;
        $page->description = $this->sanitizeRichHtml($request->description);
        $page->save();


        // SECTIONS RESET
        PageSection::where('page_id', $page->id)->delete();

        if ($request->has('sections'))
        {
            foreach ($request->sections as $order => $section)
            {
                if (!isset($section['columns'])) continue;

                foreach ($section['columns'] as $columnIndex => $column)
                {
                    PageSection::create([
                        'page_id' => $page->id,
                        'section_type' => $section['type'] ?? 'full-width',
                        'section_order' => $order,
                        'column_index' => $columnIndex,
                        'title' => isset($column['title']) ? trim((string) $column['title']) : null,
                        'content' => $this->sanitizeRichHtml($column['content'] ?? null)
                    ]);
                }
            }
        }

        return back()->with('success', 'About page updated successfully');
    }



    // ================= CONTACT PAGE =================

    public function contact()
    {

        $page = Page::firstOrCreate(
            ['slug' => 'contact']
        );

        return view('admin.pages.contact', compact('page'));
    }


    public function updateContact(Request $request)
    {

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'contact_map_src' => ['nullable', 'url', 'max:2000'],
        ]);

        $page = Page::firstOrCreate(
            ['slug' => 'contact']
        );

        $page->update($validated);

        return back()->with('success', 'Kaydedildi');
    }

    // ================= TERMS PAGE =================

    public function terms()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'terms-of-use'],
            [
                'title' => 'Terms of Use',
                'description' => '<p>By creating an account or using this website, you agree to these terms.</p>',
            ]
        );

        return view('admin.pages.terms', compact('page'));
    }

    public function updateTerms(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $page = Page::firstOrCreate(
            ['slug' => 'terms-of-use'],
            [
                'title' => 'Terms of Use',
                'description' => '',
            ]
        );

        $page->title = $validated['title'];
        $page->description = $this->sanitizeRichHtml($validated['description']) ?? '';
        $page->save();

        return back()->with('success', 'Terms page updated successfully.');
    }

    private function sanitizeRichHtml(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $clean = preg_replace('/<\s*(script|style)\b[^>]*>(.*?)<\s*\/\s*\1>/is', '', $value);
        $clean = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $clean ?? '');
        $clean = preg_replace('/javascript\s*:/i', '', $clean ?? '');

        $allowedTags = '<p><br><strong><em><ul><ol><li><a><h2><h3><h4><h5><h6><blockquote>';

        return trim(strip_tags((string) $clean, $allowedTags));
    }

    private function deleteStorageAsset(?string $assetPath): void
    {
        if (!$assetPath || !str_starts_with($assetPath, 'storage/')) {
            return;
        }

        $relativePath = ltrim(substr($assetPath, 8), '/');
        if ($relativePath === '' || str_contains($relativePath, '..')) {
            return;
        }

        $candidates = [
            base_path('../storage/' . $relativePath),
            public_path('storage/' . $relativePath),
            storage_path('app/public/' . $relativePath),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                @unlink($candidate);
            }
        }
    }

    private function storePublicUpload(\Illuminate\Http\UploadedFile $file): string
    {
        $filename = $file->hashName();
        $destination = $this->resolveUploadDestination();

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        return 'storage/uploads/' . $filename;
    }

    private function resolveUploadDestination(): string
    {
        $preferred = base_path('../storage/uploads');
        $fallback = public_path('storage/uploads');

        return is_dir(dirname($preferred)) ? $preferred : $fallback;
    }
}
