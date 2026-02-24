<?php

namespace App\Http\Controllers\Admin;

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
            $file = $request->file('hero_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $page->hero_image = '/uploads/'.$filename;
        }


        // BASIC DATA
        $page->title = $request->title;
        $page->description = $request->description;
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
                        'title' => $column['title'] ?? null,
                        'content' => $column['content'] ?? null
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

        $page = Page::firstOrCreate(
            ['slug' => 'contact']
        );

        $page->update([

            'title' => $request->title,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'contact_address' => $request->contact_address,
            'contact_map_src' => $request->contact_map_src,

        ]);

        return back()->with('success', 'Kaydedildi');
    }

}