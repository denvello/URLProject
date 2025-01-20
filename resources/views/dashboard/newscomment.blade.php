@extends('mydashboard')
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            cursor: pointer;
        }
        th:hover {
            background-color: #e2e2e2;
        }
        .level-1 td {
            padding-left: 10px;
            font-weight: bold;
            background : #bcbcbc;
        }
        .level-2 td {
            padding-left: 30px;
            color: #555;
            text-align:justify;
        }
        .level-3 td {
            padding-left: 60px;
            font-style: italic;
            color: #777;
        }
    </style>
@section('content')
<div class="table-wrapper">
    <div class="content-container">
        <h1>Links News with Comments (Last 90 Days)</h1>

         <!-- Form Pencarian Di Dashboard Admin -->
         <form method="GET" action="{{ route('dashboard.news.comments') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search links / url..." style="padding: 5px; width: 300px;">
            <button type="submit" style="padding: 5px;">Search</button>
        </form>
        <br>

        <table class="news-table">
            <thead>
                <tr>
                    <th>News Title</th>
                    <th>User</th>
                    <th>Content</th>
                    <th>Timestamp</th>
                    <th>Aktif</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($news as $newsItem)
                    <tr class="level-1">
                      
                        <td colspan="4">    
                            <a href="{{ route('cari.showdetail', ['id' => $newsItem->id, 'title' => $newsItem->title, 'urlslug' => $newsItem->url_slug]) }}" 
                                target="_blank" 
                                style="color: green; text-decoration: underline;">
                                {{ $newsItem->title }}
                            </a>    
                        <a href="{{ $newsItem->url }}" target="_blank" style="color: blue; text-decoration: underline;">
                            {{ $newsItem->url }}
                        </a> 
                        </td>
                            <!-- Status Aktif Checkbox -->
                            <td>
                                <input type="checkbox" 
                                    class="status-checkbox" 
                                    data-id="{{ $newsItem->id }}" 
                                    {{ $newsItem->status == 1 ? 'checked' : '' }}>
                            </td>
                    </tr>
                    @foreach ($newsItem->comments_join as $comment)
                        <tr class="level-2">
                            <td></td>
                            <td>{{ $comment->user->name ?? 'Anonymous' }}</td>
                            <td>{{ $comment->comment_text }}</td>
                            <td>{{ $comment->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @foreach ($comment->commentReplies as $reply)
                            <tr class="level-3">
                                <td></td>
                                <td>{{ $reply->user->name ?? 'Anonymous' }}</td>
                                <td>{{ $reply->reply_text }}</td>
                                <td>{{ $reply->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5">No news or comments found in the last 30 days.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>    
</div>
<br>
<div class="paginationr">
    {{ $news->links() }}
</div>

<!-- Tambahkan Script untuk AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-checkbox').change(function() {
            const newsId = $(this).data('id');
            const isChecked = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.updateStatusNews") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: newsId,
                    status: isChecked
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error updating status!');
                }
            });
        });
    });
</script>
@endsection

