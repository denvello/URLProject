@extends('mydashboard') <!-- Menggunakan template dashboard -->
<script>
    function sortTable(column) {
        const urlParams = new URLSearchParams(window.location.search);
        const currentDirection = urlParams.get('sort_direction') === 'asc' ? 'desc' : 'asc';

        urlParams.set('sort_by', column);
        urlParams.set('sort_direction', currentDirection);
        window.location.search = urlParams.toString();
    }
</script>

@section('content')
<div class="table-wrapper">
<div class="user-list-container">
    <h1>List of Users : ({{ $users->total() }})</h1>
   
        <table>
            <thead>
                <tr>
                    <th onclick="sortTable('name')">Name</th>
                    <th onclick="sortTable('email')">Email</th>
                    <th onclick="sortTable('role')">Role</th>
                    <th onclick="sortTable('user_ip')">IP Address</th>
                    <th onclick="sortTable('user_location')">Location</th>
                    <th onclick="sortTable('created_at')">Created At</th>
                    <th onclick="sortTable('updated_at')">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->user_ip }}</td>
                        <td>{{ $user->user_location }}</td>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
    
    </div>
</div>
<br>
    <div class="pagination">
        {{ $users->appends(request()->except('page'))->links() }}
    </div>
@endsection

@push('scripts')


@endpush

