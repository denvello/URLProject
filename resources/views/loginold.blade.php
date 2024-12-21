        @if(session('error'))
            <div class="alert alert-danger">
                <b>Opps!</b> {{session('error')}}
            </div>
        @endif
<!-- <form action="{{ url('login') }}" method="POST"> -->
<form action="{{ route('actionlogin') }}" method="post">    
    @csrf
    <label for="name">Username:</label>
    <input type="text" name="name" class="form-control" placeholder="Nama" required>
    <br>    
    <label for="name">email:</label>
    <input type="text" name="email" class="form-control" placeholder="Email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    
    <button type="submit">Login</button>
    <a href="{{route('actionlogout')}}"> Log Out</a>

</form>
