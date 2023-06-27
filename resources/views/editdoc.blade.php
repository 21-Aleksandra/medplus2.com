<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
</head>
<body>
    <h1>Edit Doctor :  {{ $doctor->name }}</h1>

    <form method="POST" action="{{ route('doctors.update', $doctor->id) }}">
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

    <!-- Edit name field -->
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $doctor->name) }}" placeholder="Enter name">
    </div>

    <!-- Edit gender field -->
    <div>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="Male" {{ old('gender', $doctor->gender) === 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender', $doctor->gender) === 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <!-- Edit profession field -->
    <div>
        <label for="profession_id">Profession:</label>
        <select id="profession_id" name="profession_id">
            <option value="">Select Profession</option>
            @foreach ($professions as $profession)
                <option value="{{ $profession->id }}" {{ old('profession_id', $doctor->profession_id) == $profession->id ? 'selected' : '' }}>
                    {{ $profession->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Edit subsidiary field -->
    <div>
        <label for="subsidiary">Subsidiary:</label>
        <select id="subsidiary" name="subsidiary_id">
            <option value="">Select Subsidiary</option>
            @foreach ($subsidiaries as $subsidiary)
                <option value="{{ $subsidiary->id }}" {{ old('subsidiary_id', $doctor->subsidiary_id) == $subsidiary->id ? 'selected' : '' }}>
                    {{ $subsidiary->naming }}
                </option>
            @endforeach
        </select>
    </div>


    <!-- Edit phone number field -->
    <div>
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}" placeholder="Enter phone number" required>
    </div>

    <!-- Edit languages field -->
    <div>
        <label>Languages:</label>
        @foreach ($languages as $language)
            <div>
                <input type="checkbox" id="{{ $language->id }}" name="languages[]" value="{{ $language->id }}" {{ in_array($language->id, old('languages', $doctor->languages->pluck('id')->toArray())) ? 'checked' : '' }}>
                <label for="{{ $language->id }}">{{ $language->name }}</label>
            </div>
        @endforeach
    </div>

    <!-- Add other form fields for editing doctor information -->

    <button type="submit">Save</button>
</form>
<a href="{{ url('/doctors') }}">Go back to doctors</a>


</body>
</html>