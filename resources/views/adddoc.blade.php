<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Doctor</title>
</head>
<body>
    <h1>Add Doctor</h1>

    <form method="POST" action="{{ route('doctors.store') }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Name field -->
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
        </div>

        <!-- Gender field -->
        <div>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <!-- Profession field -->
        <div>
    <label for="profession_id">Profession:</label>
    <select id="profession_id" name="profession_id"> <!-- Updated name attribute to profession_id -->
        <option value="">Select Profession</option>
        @foreach ($professions as $profession)
            <option value="{{ $profession->id }}" {{ old('profession_id') == $profession->id ? 'selected' : '' }}>
                {{ $profession->name }}
            </option>
        @endforeach
    </select>
</div>

        <!-- Subsidiary field -->
        <div>
    <label for="subsidiary_id">Subsidiary:</label>
    <select id="subsidiary_id" name="subsidiary_id">
        <option value="">Select Subsidiary</option>
        @foreach ($subsidiaries as $subsidiary)
            @if ($subsidiary->manager_id == auth()->id())
                <option value="{{ $subsidiary->id }}" {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : '' }}>
                    {{ $subsidiary->naming }}
                </option>
            @endif
        @endforeach
    </select>
</div>

        <!-- Phone number field -->
        <div>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
        </div>

        <!-- Languages field -->
        <div>
            <label>Languages:</label>
            @foreach ($languages as $language)
                <div>
                    <input type="checkbox" id="{{ $language->id }}" name="languages[]" value="{{ $language->id }}" {{ in_array($language->id, old('languages', [])) ? 'checked' : '' }}>
                    <label for="{{ $language->id }}">{{ $language->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit">Save</button>
    </form>

    <a href="{{ url('/doctors') }}">Go to doctor list</a>
</body>
</html>