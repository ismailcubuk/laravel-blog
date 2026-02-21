<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // SHOW About Us 
    public function about()
    {
        $aboutPage = Page::firstOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Us',
                'description' => 'Bu bizim hakkımızda yazısı',
                'hero_image' => '/assets/images/about-us.jpg'
            ]
        );

        return view('admin.pages.about', [
            'aboutPage' => $aboutPage
        ]);
    }

    // UPDATE About
public function updateAbout(Request $request)
{
    $request->validate([
        'title' => 'nullable|string',
        'description' => 'required|string',
        'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $aboutPage = Page::firstOrCreate(['slug' => 'about']);

    if ($request->hasFile('hero_image')) {
        $file = $request->file('hero_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $aboutPage->hero_image = '/uploads/' . $filename;
    }

    $aboutPage->title = $request->input('title');
    $aboutPage->description = $request->input('description');
    $aboutPage->save();

    return redirect()->route('admin.pages.about')->with('success', 'About Us page updated!');
}
}