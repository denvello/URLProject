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
            </tr>
        </thead>
        <tbody>
            @forelse ($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->title }}</td>
                    <!-- <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $feedback->id }}">
                            {{ Str::limit($feedback->description, 50) }}
                        </a>
                    </td> -->
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
                </tr>
            <!-- Modal -->
            <!-- <div class="modal fade" id="descriptionModal{{ $feedback->id }}" tabindex="-1" aria-labelledby="descriptionModalLabel{{ $feedback->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="descriptionModalLabel{{ $feedback->id }}">Description Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{ $feedback->description }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>     -->
            <!-- <div id="modal-{{ $feedback->id }}" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal({{ $feedback->id }})">&times;</span>
                    <h2>{{ $feedback->title }}</h2>
                    <div contenteditable="true" id="description" style="text-align: justify; border: 1px solid #ccc; padding: 10px; border-radius: 5px; min-height: 150px;">
                        <p class="full-description">
                            {{ $feedback->description }}
                        </p>
                    </div>
                </div>
            </div>          -->
            <!-- Modal Template -->
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
@endsection

@push('scripts')
@endpush
