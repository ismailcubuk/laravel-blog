<div class="sidebar">
    <div class="row">
        <div class="col-lg-12">
            <div class="sidebar-item search">
                <div class="sidebar-heading">
                    <h2>Arama</h2>
                </div>
                <form method="GET" action="{{ route('blog') }}">
                    <input type="text" name="search" class="searchText" placeholder="Yazı ara..." value="{{ request('search') }}" autocomplete="on">
                </form>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="sidebar-item recent-posts">
                <div class="sidebar-heading">
                    <h2>Son Yazılar</h2>
                </div>
                <div class="content">
                    <ul>
                        @foreach($recentPosts as $recent)
                            <li>
                                <a href="{{ route('post.show', ['slug' => $recent->slug]) }}">
                                    <h5>{{ $recent->title }}</h5>
                                    <span>{{ $recent->created_at->format('d M Y') }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="sidebar-item categories">
                <div class="sidebar-heading">
                    <h2>Kategoriler</h2>
                </div>
                <div class="content">
                    <ul>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blog.category', $category) }}">
                                    {{ $category->name }} ({{ $category->posts_count ?? 0 }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        @if(isset($tags) && $tags->isNotEmpty())
            <div class="col-lg-12">
                <div class="sidebar-item tags">
                    <div class="sidebar-heading">
                        <h2>Etiketler</h2>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($tags as $tag)
                                <li>
                                    <a href="{{ route('blog.tag', $tag) }}">
                                        {{ $tag->name }} ({{ $tag->posts_count ?? 0 }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
