<h1>Welcome, <b>{{Auth::user()->name}}</b></h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
