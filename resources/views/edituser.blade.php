<!DOCTYPE html>
<html>
<head>
    <title>{{ __('user.edit_user') }}</title>
</head>
<body>
    <h1>{{ __('user.edit_user') }}</h1>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">{{ __('user.name') }}:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('user.email') }}:</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="form-group">
                        <label for="role">{{ __('user.role') }}:</label>
                        <select class="form-control" id="role" name="role">
                            <option value="0" {{ old('role', $user->role) == 0 ? 'selected' : '' }}>{{ __('user.select_role') }} 0</option>
                            <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>{{ __('user.select_role') }} 1</option>
                            <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>{{ __('user.select_role') }} 2</option>
                            <option value="3" {{ old('role', $user->role) == 3 ? 'selected' : '' }}>{{ __('user.select_role') }} 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('user.password') }}:</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ __('user.update_user') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>