<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('user.title') }}</title>
</head>
<body>
    <h1>{{ __('user.title') }}</h1>
    <div class="container">
        <div class="card">
            <div class="card-body">
            @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('user.name') }}:</label>
                        <input type="text" class="form-control" id="name" name="name"  value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('user.email') }}:</label>
                        <input type="text" class="form-control" id="email" name="email"  value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('user.password') }}:</label>
                        <input type="password" class="form-control" id="password" name="password" >
                    </div>

                    <div class="form-group">
                        <label for="role">{{ __('user.role') }}:</label>
                        <select class="form-control" id="role" name="role" >
                            <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>{{ __('user.select_role') }} 0</option>
                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>{{ __('user.select_role') }} 1</option>
                            <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>{{ __('user.select_role') }} 2</option>
                            <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>{{ __('user.select_role') }} 3</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ __('user.add_user') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('user.back_to_users') }}</a>
</body>
</html>