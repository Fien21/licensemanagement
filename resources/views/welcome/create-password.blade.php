<!DOCTYPE html>
<html>
<head>
    <title>Create Admin Password</title>
</head>
<body>
    <h2>Create Admin Password</h2>

    <form method="POST" action="{{ url('/admin/create-password') }}">
        @csrf
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation" required>
        <br>
        <button type="submit">Set Password</button>
    </form>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
