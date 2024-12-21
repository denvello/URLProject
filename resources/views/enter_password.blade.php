<form action="{{ route('verify_password') }}" method="post">
    @csrf
    <label for="password">Masukkan Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Verifikasi</button>
</form>
@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
