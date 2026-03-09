<div class="all-blog-posts">
    <div class="row">

        @foreach($posts as $post)
            <div class="col-lg-12">
                <div class="blog-post">

                    <div class="blog-thumb">
                        <a href="{{ route('post.show', $post->slug) }}">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                        </a>
                    </div>


                    <div class="down-content">

                        {{-- category --}}
                        <span>{{ $post->category->name }}</span>

                        {{-- title --}}
                        <a href="{{ route('post.show', $post->slug) }}">
                            <h4>{{ $post->title }}</h4>
                        </a>

                        <ul class="post-info">
                            <li><a href="#">Admin</a></li>

                            {{-- date --}}
                            <li>
                                <a href="#">
                                    {{ $post->created_at->format('M d, Y') }}
                                </a>
                            </li>

                            <li><a href="{{ route('post.show', $post->slug) }}#comments">{{ $post->approved_comments_count ?? 0 }} Comments</a></li>
                        </ul>

                        {{-- content --}}
                        <p>
                            {{ Str::limit($post->content, 150) }}
                        </p>

                        <div class="main-button">
                            <a href="{{ route('post.show', $post->slug) }}">
                                Read More
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        @endforeach

    </div>
</div>
