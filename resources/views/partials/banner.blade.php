<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">

            @foreach($bannerPosts as $post)

                <div class="item">

                    {{-- image --}}
                    <a href="{{ route('post.show', $post->slug) }}">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                    </a>

                    <div class="item-content">
                        <div class="main-content">

                            {{-- category --}}
                            <div class="meta-category">
                                <span>{{ $post->category->name }}</span>
                            </div>

                            {{-- title --}}
                            <a href="{{ route('post.show', $post->slug) }}">
                                <h4>{{ $post->title }}</h4>
                            </a>

                            <ul class="post-info">

                                {{-- author --}}
                                <li>
                                    <a href="#">Admin</a>
                                </li>

                                {{-- date --}}
                                <li>
                                    <a href="#">
                                        {{ $post->created_at->format('M d, Y') }}
                                    </a>
                                </li>

                                {{-- comments --}}
                                <li>
                                    <a href="{{ route('post.show', $post->slug) }}#comments">{{ $post->approved_comments_count ?? 0 }} Comments</a>
                                </li>

                            </ul>

                        </div>
                    </div>

                </div>

            @endforeach

        </div>
    </div>
</div>
