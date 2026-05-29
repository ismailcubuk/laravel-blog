<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $authors = collect([
            [
                'name' => 'Emma Carter',
                'email' => 'emma.carter@example.com',
                'bio' => 'Lifestyle writer focused on simple everyday routines.',
                'avatar_path' => 'assets/images/avatars/emma-carter.png',
            ],
            [
                'name' => 'Noah Bennett',
                'email' => 'noah.bennett@example.com',
                'bio' => 'Travel and city guide writer.',
                'avatar_path' => 'assets/images/avatars/noah-bennett.png',
            ],
            [
                'name' => 'Mia Brooks',
                'email' => 'mia.brooks@example.com',
                'bio' => 'Home, food, and practical living editor.',
                'avatar_path' => 'assets/images/avatars/mia-brooks.png',
            ],
        ])->mapWithKeys(function (array $author) {
            $user = User::query()->updateOrCreate(
                ['email' => $author['email']],
                [
                    'name' => $author['name'],
                    'password' => 'password',
                    'role' => 'user',
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'bio' => $author['bio'],
                    'avatar_path' => $author['avatar_path'],
                ]
            );

            return [$author['email'] => $user];
        });

        $categories = collect([
            'Food',
            'Travel',
            'Home',
            'Gardening',
            'Outdoor',
            'Lifestyle',
        ])->mapWithKeys(function (string $name) {
            $category = Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );

            return [$name => $category];
        });

        $oldSeedTitles = [
            'Laravel ile Kucuk Ekipler Icin Yonetilebilir Blog Altyapisi',
            '2026da Web Performansi Icin Pratik Kontrol Listesi',
            'Admin Panellerinde Rol ve Yetki Tasarimi Nasil Kurgulanir',
            'Temiz Bir Blog Arayuzu Icin Okunabilirlik Ilkeleri',
            'Uzaktan Calisan Gelistiriciler Icin Haftalik Planlama Rutini',
            'Iyi Bir Iletisim Sayfasi Sadece Formdan Ibarettir Sanmayin',
            'Junior Gelistiriciler Icin Portfolyo Blogu Neden Hala Degerli',
            'Yorum Moderasyonu Olan Bloglarda Topluluk Kalitesi Nasil Korunur',
        ];

        Post::query()
            ->whereIn('slug', collect($oldSeedTitles)->map(fn (string $title) => Str::slug($title)))
            ->delete();

        $posts = [
            [
                'title' => 'How to Brew Better Coffee at Home',
                'category' => 'Food',
                'author' => 'emma.carter@example.com',
                'image' => 'assets/images/seed/coffee-at-home.png',
                'featured' => true,
                'tags' => ['Coffee', 'Kitchen', 'Morning'],
                'description' => 'A simple guide to making smoother and more consistent coffee in your own kitchen.',
                'content' => [
                    'Good coffee at home starts with small habits rather than expensive equipment. Fresh beans, clean water, and a steady brewing routine can change the taste more than most people expect.',
                    'Grind size matters because it controls how quickly water passes through the coffee. If the cup tastes bitter, try a slightly coarser grind. If it tastes weak or sour, try a finer one and keep the water temperature steady.',
                    'The easiest way to improve is to repeat the same recipe for a few mornings. Measure the coffee, use the same mug, and adjust one detail at a time until the flavor feels balanced.',
                ],
            ],
            [
                'title' => 'Best Places to Visit in Ankara in One Day',
                'category' => 'Travel',
                'author' => 'noah.bennett@example.com',
                'image' => 'assets/images/seed/ankara-one-day.png',
                'featured' => true,
                'tags' => ['Ankara', 'City Guide', 'Weekend'],
                'description' => 'A realistic one-day Ankara route for museums, parks, city views, and relaxed coffee stops.',
                'content' => [
                    'Ankara is easy to underestimate if you only pass through it. A good one-day route can include a museum visit, a slow walk through a central neighborhood, and a quiet stop for coffee before sunset.',
                    'Start early so you can avoid rushing between places. Pick two main stops instead of trying to see everything. The city feels better when you leave time for small streets, bookshops, and local cafes.',
                    'Comfortable shoes make the day much easier because Ankara has hills and wide avenues. Keep the plan flexible, check opening hours, and save one hour at the end for an unplanned discovery.',
                ],
            ],
            [
                'title' => 'Simple Weeknight Dinner Ideas',
                'category' => 'Food',
                'author' => 'mia.brooks@example.com',
                'image' => 'assets/images/seed/weeknight-dinner.png',
                'featured' => false,
                'tags' => ['Dinner', 'Cooking', 'Meal Prep'],
                'description' => 'Easy dinner ideas for busy evenings when you still want something warm and homemade.',
                'content' => [
                    'Weeknight dinners should be realistic. A useful meal plan is not about cooking something impressive every night; it is about having a few flexible combinations ready.',
                    'Keep a base, a protein, and a vegetable on hand. Rice with roasted vegetables, pasta with a quick sauce, or eggs with a salad can become a complete dinner in less than thirty minutes.',
                    'Leftovers are part of the plan. Cook a little extra grain or vegetables once, then reuse them the next day with a different sauce or topping so the meal still feels fresh.',
                ],
            ],
            [
                'title' => 'How to Start a Small Balcony Garden',
                'category' => 'Gardening',
                'author' => 'emma.carter@example.com',
                'image' => 'assets/images/seed/balcony-garden.png',
                'featured' => false,
                'tags' => ['Plants', 'Balcony', 'Home'],
                'description' => 'Beginner-friendly steps for growing herbs and small vegetables on an apartment balcony.',
                'content' => [
                    'A balcony garden does not need much space. Start with two or three plants you will actually use, such as mint, basil, parsley, or small tomatoes.',
                    'The most important detail is sunlight. Watch your balcony for a few days and notice how many hours of direct light it gets. Herbs can handle partial sun, while tomatoes usually need more.',
                    'Use pots with drainage holes and avoid overwatering. Most beginner problems come from soil staying wet for too long, so check the top layer before adding more water.',
                ],
            ],
            [
                'title' => "A Beginner's Guide to Weekend Hiking",
                'category' => 'Outdoor',
                'author' => 'noah.bennett@example.com',
                'image' => 'assets/images/seed/weekend-hiking.png',
                'featured' => false,
                'tags' => ['Hiking', 'Outdoors', 'Weekend'],
                'description' => 'A practical hiking guide for people who want to start with short and comfortable weekend trails.',
                'content' => [
                    'Weekend hiking is easier to start when you choose short routes close to the city. The goal for the first trip is not distance; it is learning what feels comfortable.',
                    'Bring water, a small snack, a charged phone, and a light layer even if the weather looks warm. Trail conditions can change quickly, especially in shaded areas.',
                    'Good shoes matter more than a big backpack. Pick a route with clear markings, tell someone where you are going, and give yourself enough time to return before dark.',
                ],
            ],
            [
                'title' => 'Keeping Your Desk Organized Without Buying More Stuff',
                'category' => 'Home',
                'author' => 'mia.brooks@example.com',
                'image' => 'assets/images/seed/organized-desk.png',
                'featured' => false,
                'tags' => ['Workspace', 'Organization', 'Home Office'],
                'description' => 'Simple desk organization ideas using what you already have at home.',
                'content' => [
                    'A clean desk is less about buying organizers and more about deciding what belongs within reach. Start by removing everything, then put back only the items you use every day.',
                    'Cables, notebooks, and loose papers are usually the main source of clutter. Reuse small boxes, clips, or jars to create simple zones instead of adding more products to the desk.',
                    'End each day with a two-minute reset. Close the notebook, clear empty cups, and prepare the one thing you need first tomorrow morning.',
                ],
            ],
            [
                'title' => 'Planning a Budget-Friendly Weekend Trip',
                'category' => 'Travel',
                'author' => 'noah.bennett@example.com',
                'image' => 'assets/images/seed/budget-weekend-trip.png',
                'featured' => false,
                'tags' => ['Budget Travel', 'Planning', 'Weekend'],
                'description' => 'How to plan a short trip without overspending on transport, food, and last-minute choices.',
                'content' => [
                    'A budget-friendly trip starts before you leave home. Choose one main destination, compare transport options early, and keep the schedule simple enough to avoid extra taxi rides.',
                    'Food is where small costs add up quickly. Plan one nice meal, then balance it with local bakeries, markets, or simple picnic stops during the day.',
                    'Leave room for one unplanned activity. A strict plan can feel cheaper on paper but more stressful in real life, so keep a small flexible budget for the moment that makes the trip memorable.',
                ],
            ],
            [
                'title' => 'Building a Simple Morning Routine',
                'category' => 'Lifestyle',
                'author' => 'emma.carter@example.com',
                'image' => 'assets/images/seed/morning-routine.png',
                'featured' => false,
                'tags' => ['Morning', 'Habits', 'Routine'],
                'description' => 'A calm morning routine built around realistic habits instead of strict productivity rules.',
                'content' => [
                    'A morning routine works best when it is small enough to repeat. You do not need a perfect two-hour plan; ten quiet minutes can change the tone of the day.',
                    'Start with one anchor habit, such as drinking water, opening the window, making coffee, or writing three lines in a notebook. The habit should be easy even on a busy day.',
                    'Prepare the night before if mornings feel rushed. Put clothes in one place, clear the kitchen counter, and decide the first task of the next day before going to sleep.',
                ],
            ],
        ];

        foreach ($posts as $index => $postData) {
            $createdAt = Carbon::now()->subDays(18 - $index)->setTime(10 + ($index % 6), 15);
            $content = collect($postData['content'])
                ->map(fn (string $paragraph) => '<p>' . e($paragraph) . '</p>')
                ->implode("\n");

            $payload = [
                'title' => $postData['title'],
                'content' => $content,
                'image' => $postData['image'],
                'category_id' => $categories[$postData['category']]->id,
                'user_id' => $authors[$postData['author']]->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            if (Schema::hasColumn('posts', 'status')) {
                $payload['status'] = 'published';
            }

            if (Post::featuredColumnsExist()) {
                $payload['is_featured'] = $postData['featured'];
                $payload['featured_at'] = $postData['featured'] ? $createdAt : null;
            }

            if (Post::seoColumnsExist()) {
                $payload['meta_title'] = $postData['title'];
                $payload['meta_description'] = $postData['description'];
                $payload['og_image'] = $postData['image'];
            }

            $post = Post::query()->updateOrCreate(
                ['slug' => Str::slug($postData['title'])],
                $payload
            );

            if (Post::tagsTableExists()) {
                $tagIds = collect($postData['tags'])->map(function (string $tagName) {
                    return Tag::query()->updateOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    )->id;
                });

                $post->tags()->sync($tagIds);
            }
        }
    }
}
