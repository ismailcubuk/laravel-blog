<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{

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

// SECTİONS
$sections = PageSection::where('page_id', $page->id)
->orderBy('section_order')
->orderBy('column_index')
->get()
->groupBy('section_order');


// VİEWS
return view('admin.pages.about', compact('page', 'sections'));
}

public function updateAbout(Request $request)
{

// VALIDATION
$request->validate([
    'title' => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    'sections' => 'nullable|array'
]);

// PAGE
$page = Page::firstOrCreate(
    ['slug' => 'about-us'],
    [
        'title' => 'About Us',
        'description' => '',
        'hero_image' => null
    ]
);

// HERO IMAGE UPLOAD
if ($request->hasFile('hero_image'))
{
    $file = $request->file('hero_image');
    $filename = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('uploads'), $filename);
    $page->hero_image = '/uploads/'.$filename;
}

// BASIC PAGE DATA
$page->title = $request->input('title');
$page->description = $request->input('description');
$page->save();

// SECTIONS UPDATE
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
                'title' => $column['title'] ?? null,
                'content' => $column['content'] ?? null
            ]);
        }
    }
}

// REDIRECT
return back()->with('success', 'About page updated successfully');
}
}