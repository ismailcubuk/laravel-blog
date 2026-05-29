<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        if (!Post::query()->exists()) {
            return;
        }

        $admin = User::query()
            ->where('role', 'admin')
            ->orWhereHas('roles', fn ($query) => $query->where('name', 'Admin'))
            ->first();

        $commentsByPost = [
            'How to Brew Better Coffee at Home' => [
                [
                    'name' => 'Daniel Reed',
                    'email' => 'daniel.reed@example.com',
                    'message' => 'The point about changing only one variable at a time helped a lot. I kept changing grind size and water amount together, so I never knew what fixed the taste.',
                    'reply' => 'That is the easiest trap with home coffee. A simple repeatable recipe makes every adjustment much clearer.',
                ],
                [
                    'name' => 'Laura Smith',
                    'email' => 'laura.smith@example.com',
                    'message' => 'I tried using filtered water this morning and the coffee already tasted cleaner. Small detail, big difference.',
                ],
                [
                    'name' => 'Mark Ellis',
                    'email' => 'mark.ellis@example.com',
                    'message' => 'Would love a follow-up about budget-friendly grinders for beginners.',
                    'status' => 'pending',
                ],
            ],
            'Best Places to Visit in Ankara in One Day' => [
                [
                    'name' => 'Aylin Moore',
                    'email' => 'aylin.moore@example.com',
                    'message' => 'I like that this route does not try to fit ten stops into one day. Ankara is much nicer when you leave time for walking.',
                    'reply' => 'Exactly. The city rewards a slower plan, especially if you want to enjoy cafes and side streets.',
                ],
                [
                    'name' => 'Jonas Clark',
                    'email' => 'jonas.clark@example.com',
                    'message' => 'Comfortable shoes are a real tip for Ankara. The hills surprise first-time visitors.',
                ],
                [
                    'name' => 'Selin Park',
                    'email' => 'selin.park@example.com',
                    'message' => 'I would also add a sunset viewpoint if the weather is clear. It makes the day feel complete.',
                ],
            ],
            'Simple Weeknight Dinner Ideas' => [
                [
                    'name' => 'Rachel Green',
                    'email' => 'rachel.green@example.com',
                    'message' => 'The base-protein-vegetable formula is easy to remember. It makes dinner feel less like a decision every night.',
                ],
                [
                    'name' => 'Owen Miller',
                    'email' => 'owen.miller@example.com',
                    'message' => 'Leftover rice with eggs and vegetables saved me twice this week. Simple but very practical.',
                    'reply' => 'That is a perfect weeknight example. A few flexible leftovers can turn into several different meals.',
                ],
            ],
            'How to Start a Small Balcony Garden' => [
                [
                    'name' => 'Nina Wilson',
                    'email' => 'nina.wilson@example.com',
                    'message' => 'Starting with herbs is great advice. I tried too many plants last year and could not keep up with them.',
                ],
                [
                    'name' => 'Peter Young',
                    'email' => 'peter.young@example.com',
                    'message' => 'Drainage holes are underrated. My first basil plant failed because the pot held too much water.',
                    'reply' => 'That happens often. Good drainage is usually more important than the perfect pot size.',
                ],
            ],
            "A Beginner's Guide to Weekend Hiking" => [
                [
                    'name' => 'Sophie Lane',
                    'email' => 'sophie.lane@example.com',
                    'message' => 'Choosing a short first route makes hiking feel much less intimidating. I wish someone had told me that earlier.',
                ],
                [
                    'name' => 'Kevin Adams',
                    'email' => 'kevin.adams@example.com',
                    'message' => 'The light layer tip is real. I have been cold on trails even when the city felt warm.',
                    'reply' => 'Trail shade and wind can change things quickly, so a small layer is always worth carrying.',
                ],
            ],
            'Keeping Your Desk Organized Without Buying More Stuff' => [
                [
                    'name' => 'Grace Turner',
                    'email' => 'grace.turner@example.com',
                    'message' => 'I appreciate the no-shopping approach. Most organization posts just make me want to buy more containers.',
                    'reply' => 'A desk usually needs fewer things first, not more things. Reusing what you have keeps it realistic.',
                ],
                [
                    'name' => 'Henry Scott',
                    'email' => 'henry.scott@example.com',
                    'message' => 'The two-minute reset is small enough that I might actually do it every day.',
                ],
            ],
            'Planning a Budget-Friendly Weekend Trip' => [
                [
                    'name' => 'Ella Morgan',
                    'email' => 'ella.morgan@example.com',
                    'message' => 'Planning one nice meal instead of trying to eat out all weekend is a smart balance.',
                ],
                [
                    'name' => 'Sam Rivera',
                    'email' => 'sam.rivera@example.com',
                    'message' => 'Leaving a small flexible budget is the part I always forget. Then every unplanned stop feels stressful.',
                    'reply' => 'A little flexible money can make the trip feel lighter without ruining the budget.',
                ],
            ],
            'Building a Simple Morning Routine' => [
                [
                    'name' => 'Chloe Evans',
                    'email' => 'chloe.evans@example.com',
                    'message' => 'I like the idea of one anchor habit. A full morning routine always felt too strict for me.',
                ],
                [
                    'name' => 'Liam Foster',
                    'email' => 'liam.foster@example.com',
                    'message' => 'Preparing the first task the night before helps a lot. It removes the morning decision fatigue.',
                    'reply' => 'That small evening step can make the next morning feel much calmer.',
                ],
                [
                    'name' => 'Promo Bot',
                    'email' => 'promo.bot@example.com',
                    'message' => 'Visit my unrelated discount page for amazing deals.',
                    'status' => 'spam',
                ],
            ],
        ];

        foreach ($commentsByPost as $postTitle => $comments) {
            $post = Post::query()->where('slug', Str::slug($postTitle))->first();

            if (!$post) {
                continue;
            }

            foreach ($comments as $index => $commentData) {
                $createdAt = Carbon::parse($post->created_at)->addHours(6 + ($index * 9));
                $status = $commentData['status'] ?? 'approved';
                $replyMessage = $commentData['reply'] ?? null;

                Comment::query()->updateOrCreate(
                    [
                        'post_id' => $post->id,
                        'email' => $commentData['email'],
                        'message' => $commentData['message'],
                    ],
                    [
                        'user_id' => null,
                        'name' => $commentData['name'],
                        'status' => $status,
                        'reply_message' => $replyMessage,
                        'replied_by_user_id' => $replyMessage && $admin ? $admin->id : null,
                        'replied_at' => $replyMessage ? $createdAt->copy()->addHours(3) : null,
                        'created_at' => $createdAt,
                        'updated_at' => $replyMessage ? $createdAt->copy()->addHours(3) : $createdAt,
                    ]
                );
            }

            if (Schema::hasColumn('comments', 'parent_id')) {
                $firstComment = Comment::query()
                    ->where('post_id', $post->id)
                    ->where('status', 'approved')
                    ->whereNull('parent_id')
                    ->oldest()
                    ->first();

                if ($firstComment) {
                    Comment::query()->updateOrCreate(
                        [
                            'post_id' => $post->id,
                            'parent_id' => $firstComment->id,
                            'email' => 'reply.' . $post->id . '@example.com',
                        ],
                        [
                            'user_id' => null,
                            'name' => 'Another Reader',
                            'message' => 'I agree with this comment. The examples make the advice feel easy to try.',
                            'status' => 'approved',
                            'created_at' => Carbon::parse($firstComment->created_at)->addHours(2),
                            'updated_at' => Carbon::parse($firstComment->created_at)->addHours(2),
                        ]
                    );
                }
            }
        }
    }
}
