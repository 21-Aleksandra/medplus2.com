<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('doctors.adddoc') }}</title>
</head>
<body>
    <h1>{{ __('doctors.adddoc') }}</h1>

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
            <label for="name">{{ __('doctors.name') }}:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('doctors.enter') }}">
        </div>

        <!-- Gender field -->
        <div>
            <label for="gender">{{ __('doctors.gender') }}:</label>
            <select id="gender" name="gender">
                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>{{ __('doctors.male') }}</option>
                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>{{ __('doctors.female') }}</option>
            </select>
        </div>

        <!-- Profession field -->
        <div>
            <label for="profession_id">{{ __('doctors.profession') }}:</label>
            <select id="profession_id" name="profession_id">
                <option value="">{{ __('doctors.allprof') }}</option>
                @foreach ($professions as $profession)
                    <option value="{{ $profession->id }}" {{ old('profession_id') == $profession->id ? 'selected' : '' }}>
                        {{ $profession->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Subsidiary field -->
        <div>
            <label for="subsidiary_id">{{ __('doctors.subsidiary') }}:</label>
            <select id="subsidiary_id" name="subsidiary_id">
                <option value="">{{ __('doctors.allsub') }}</option>
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
            <label for="phone">{{ __('doctors.phone') }}:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ __('doctors.enter2') }}">
        </div>

        <!-- Languages field -->
        <div>
            <label>{{ __('doctors.languages') }}:</label>
            @foreach ($languages as $language)
                <div>
                    <input type="checkbox" id="{{ $language->id }}" name="languages[]" value="{{ $language->id }}" {{ in_array($language->id, old('languages', [])) ? 'checked' : '' }}>
                    <label for="{{ $language->id }}">{{ $language->code }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit">{{ __('doctors.save') }}</button>
    </form>

    <a href="{{ url('/doctors') }}">Go to doctor list</a>
</body>
</html>