@extends('mydashboard')

<script>
    function sortTable(column) {
    const urlParams = new URLSearchParams(window.location.search);
    const currentDirection = urlParams.get('sort_direction') || 'asc'; // Default is asc
    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc'; // Toggle direction

    urlParams.set('sort_by', column);
    urlParams.set('sort_direction', newDirection);
    window.location.search = urlParams.toString();
}

</script>

@section('content')
<div class="table-wrapper">
    <h1>Feedback Details : ({{ $feedbacks->total() }})</h1>
    <table>
        <thead>
            <tr>
                <th onclick="sortTable('id')">ID</th>
                <th onclick="sortTable('title')">Title</th>
                <th onclick="sortTable('description')">Description</th>
                <th onclick="sortTable('category')">Category</th>
                <th onclick="sortTable('username')">User Name</th>
                <th onclick="sortTable('created_at')">Feedback Date</th>
                <th onclick="sortTable('upvotes')">Upvotes</th>
                <th onclick="sortTable('downvotes')">Downvotes</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->title }}</td>
                    <td>{{ Str::limit($feedback->description, 50) }}</td>
                    <td>{{ $feedback->category }}</td>
                    <td>{{ $feedback->user->name ?? 'Anonymous' }}</td>
                    <td>{{ $feedback->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $feedback->upvotes }}</td>
                    <td>{{ $feedback->downvotes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No feedbacks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<br>
<div class="pagination">
    {{ $feedbacks->appends(request()->except('page'))->links() }}
</div>
@endsection

@push('scripts')
@endpush
