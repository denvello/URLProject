@extends('mydashboard')

@push('styles')
<style>
    

    /* .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    } */
</style>
@endpush

@section('content')
<!-- <div class="table-wrapper"> -->
<!-- <div class="user-profile-container"> -->
    <h2>User Profiles of : ({{ $users->total() }})</h2>
    
    <div class="search-container">
        <form action="{{ route('dashboard.userprofile') }}" method="GET">
            <input type="text" name="search" placeholder="Search by name or email" value="{{ request('search') }}">
        </form>
    </div>
    <br>
    <br>
    @forelse ($users as $user)
        <div class="profile-details">
            <div class="avatar-container">
                <img class="user-avatar" src="{{ $user->user_avatar ? asset($user->user_avatar) : asset('img/default-avatar.png') }}" alt="Avatar">
            </div>
            <div class="profile-info">
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $user->name }} - ({{ $user->id }})</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Role:</span>
                    <span class="info-value">{{ $user->role }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">IP Address:</span>
                    <span class="info-value">{{ $user->user_ip }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">User Agent:</span>
                    <span class="info-value">{{ $user->user_agent }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Location:</span>
                    <span class="info-value">{{ $user->user_location }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Joined At:</span>
                    <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Comments:</span>
                    <span class="info-value">{{ $user->comments->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Reply:</span>
                    <span class="info-value">{{ $user->replyComments->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Products:</span>
                    <span class="info-value">{{ $user->products->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Updated:</span>
                    <span class="info-value">{{ $user->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
        <br>
    @empty
        <p>No users found.</p>
    @endforelse
    <br>
    <div class="pagination">
        {{ $users->links() }}
    </div>
<!-- </div> -->
<!-- </div> -->
@endsection
