<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')->latest()->paginate(10);

        return view('admin.content.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => $this->generateUniqueSlug($validated['name']),
        ]);

        return redirect()->route('admin.content.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => $this->generateUniqueSlug($validated['name'], $category->id),
        ]);

        return redirect()->route('admin.content.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return redirect()->route('admin.content.categories.index')
                ->with('error', 'Category cannot be deleted because it has posts.');
        }

        $category->delete();

        return redirect()->route('admin.content.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    private function generateUniqueSlug(string $name, ?int $ignoreCategoryId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug !== '' ? $baseSlug : 'category';
        $counter = 1;

        while (
            Category::query()
                ->when($ignoreCategoryId, fn ($query) => $query->where('id', '!=', $ignoreCategoryId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}


