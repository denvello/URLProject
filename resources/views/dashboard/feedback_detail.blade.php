@extends('mydashboard')
@push('styles')
<style>
/* Modal Content */
   
    
</style>
@endpush

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
<script>
        function handleCardClick(feedbackId) {
            const modal = document.getElementById(`modal-${feedbackId}`);
            if (modal) {
                modal.style.display = 'flex';
            }
        }


        function closeModal(feedbackId) {
            const modal = document.getElementById(`modal-${feedbackId}`);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Close the modal when clicking outside
        window.onclick = function (event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        };
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
                <th>Status Aktif</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->title }}</td>
                    <td>
                        <a href="javascript:void(0)" onclick="handleCardClick({{ $feedback->id }})" style="text-decoration: none; color: inherit;">
                            {{ Str::limit($feedback->description, 100) }}
                        </a>
                    </td>
                    <td>{{ $feedback->category }}</td>
                    <td>{{ $feedback->user->name ?? 'Anonymous' }}</td>
                    <td>{{ $feedback->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $feedback->upvotes }}</td>
                    <td>{{ $feedback->downvotes }}</td>
                    <td>
                        <input type="checkbox" 
                        class="status-checkbox" 
                        data-id="{{ $feedback->id }}" 
                        {{ $feedback->statusfeedback == 1 ? 'checked' : '' }}>
                    </td>
                </tr>
           
            @foreach ($feedbacks as $feedback)
            <div id="modal-{{ $feedback->id }}" class="modal">
                <div class="modal-contentF">
                    <span class="closeF" onclick="closeModal({{ $feedback->id }})">&times;</span>
                    <h2>{{ $feedback->title }}</h2>
                    <div class="full-description">
                        {{ $feedback->description }}
                    </div>
                </div>
            </div>
            @endforeach
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

<!-- Tambahkan Script untuk AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-checkbox').change(function() {
            const feedId = $(this).data('id');
            const isChecked = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.updateStatusFeed") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: feedId,
                    statusfeedback: isChecked
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

@push('scripts')
@endpush
