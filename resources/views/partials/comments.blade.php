@foreach ($comments as $comment)
<div>
    <p><strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>:</p>
    <p>{{ $comment->comment_text }}</p>
    <div style="flex: 0 0 100px; margin-right: 30px;">
        @if($comment->user && $comment->user->user_avatar)
            img src="{{ $comment->user->user_avatar }}" alt="User Avatar" style="max-width: 100%; height: auto; border-radius: 50%;">
        @else
            <img src="{{ asset('storage/image/no-image-crop.png') }}" alt="No Avatar" style="max-width: 100%; height: auto; border-radius: 50%;">
        @endif
    </div>
    <!-- Komentar Utama -->
    <p><strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>:</p>
    <p>{{ $comment->comment_text }}</p>
    
    <!-- @if ($comment->commentReplies->count())
        <div class="replies">
            @foreach ($comment->commentReplies as $reply)
                <p><strong>{{ $reply->user->name ?? 'Anonymous' }}</strong>: {{ $reply->reply_text }}</p>
            @endforeach
        </div>
    @endif -->

                                        @push('scripts')                        
                                            <script>
                                                let page = 1; // Start with the first page
                                                let isLoading = false;
                                                // Lazy loading on scroll
                                                window.addEventListener('scroll', () => {
                                                    console.log('Scroll detected'); // Add this line for debugging    
                                                    if (isLoading) return;

                                                    // Check if the user scrolled near the bottom of the page
                                                    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                                                        loadMoreComments();
                                                    }
                                                });

                                                function loadMoreComments() {
                                                    if (isLoading) {
                                                        console.log('Already loading comments'); // Debugging
                                                        return;
                                                    }

                                                    console.log('Fetching comments for page', page); // Debugging

                                                    if (isLoading) return;

                                                    isLoading = true;
                                                    document.getElementById('loading-spinner').style.display = 'block';

                                                    fetch(`{{ route('news.comments.fetch', $newsurljoin->id) }}?page=${page}`, {
                                                        method: 'GET',
                                                        headers: {
                                                            'X-Requested-With': 'XMLHttpRequest',
                                                        },
                                                    })
                                                    .then(response => response.text())
                                                    .then(html => {
                                                        const commentsContainer = document.getElementById('comments-container');
                                                        commentsContainer.insertAdjacentHTML('beforeend', html);

                                                        // Check if there are more comments
                                                        if (html.trim() !== '') {
                                                            page += 1; // Increment page for the next request
                                                        } else {
                                                            // No more comments to load
                                                            window.removeEventListener('scroll', handleScroll);
                                                        }

                                                        document.getElementById('loading-spinner').style.display = 'none';
                                                        isLoading = false;
                                                    })
                                                    .catch(error => {
                                                        console.error('Error loading comments:', error);
                                                        document.getElementById('loading-spinner').style.display = 'none';
                                                        isLoading = false;
                                                    });
                                                }

                                                function handleScroll() {
                                                    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                                                        loadComments();
                                                    }
                                                }

                                                // Attach scroll event listener
                                                window.addEventListener('scroll', handleScroll);

                                                // Load the first page of comments
                                                document.addEventListener('DOMContentLoaded', loadComments);
                                            </script>
                                        @endpush
    
</div>
@endforeach
