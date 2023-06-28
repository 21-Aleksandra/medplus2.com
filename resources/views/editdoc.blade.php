<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('doctors.editdoc') }} : {{ $doctor->name }}</title>
</head>
<body>
    <h1>{{ __('doctors.editdoc') }} : {{ $doctor->name }}</h1>

    <form method="POST" action="{{ route('doctors.update', $doctor->id) }}" enctype="multipart/form-data">
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
            <label for="name">{{ __('doctors.name') }}:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $doctor->name) }}" placeholder="{{ __('doctors.enter') }}">
        </div>

        <!-- Edit gender field -->
        <div>
            <label for="gender">{{ __('doctors.gender') }}:</label>
            <select id="gender" name="gender">
                <option value="Male" {{ old('gender', $doctor->gender) === 'Male' ? 'selected' : '' }}>{{ __('doctors.male') }}</option>
                <option value="Female" {{ old('gender', $doctor->gender) === 'Female' ? 'selected' : '' }}>{{ __('doctors.female') }}</option>
            </select>
        </div>

        <!-- Edit profession field -->
        <div>
            <label for="profession_id">{{ __('doctors.profession') }}:</label>
            <select id="profession_id" name="profession_id">
                <option value="">{{ __('doctors.allprof') }}</option>
                @foreach ($professions as $profession)
                    <option value="{{ $profession->id }}" {{ old('profession_id', $doctor->profession_id) == $profession->id ? 'selected' : '' }}>
                        {{ $profession->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Edit subsidiary field -->
        <div>
            <label for="subsidiary">{{ __('doctors.subsidiary') }}:</label>
            <select id="subsidiary" name="subsidiary_id">
                <option value="">{{ __('doctors.allsub') }}</option>
                @foreach ($subsidiaries as $subsidiary)
                    <option value="{{ $subsidiary->id }}" {{ old('subsidiary_id', $doctor->subsidiary_id) == $subsidiary->id ? 'selected' : '' }}>
                        {{ $subsidiary->naming }}
                    </option>
                @endforeach
            </select>
        </div>


        <!-- Edit phone number field -->
        <div>
            <label for="phone">{{ __('doctors.phone') }}:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}" placeholder="{{ __('doctors.enter') }}" required>
        </div>

        <!-- Edit languages field -->
        <div>
            <label>{{ __('doctors.languages') }}:</label>
            @foreach ($languages as $language)
                <div>
                    <input type="checkbox" id="{{ $language->id }}" name="languages[]" value="{{ $language->id }}" {{ in_array($language->id, old('languages', $doctor->languages->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label for="{{ $language->id }}">{{ $language->code }}</label>
                </div>
            @endforeach
        </div>

        <div>
    <label for="image">{{ __('doctors.image') }}:</label>
    <input type="file" id="image" name="image" accept="image/*" required>
</div>
        

        <!-- Add other form fields for editing doctor information -->

        <button type="submit">{{ __('doctors.save') }}</button>
    </form>

<a href="{{ url('/doctors') }}">Go back to doctors</a>


</body>
</html>