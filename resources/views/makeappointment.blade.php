<!DOCTYPE html>
<html>

<head>
    <title>{{ __('appointments.title') }}</title>
</head>

<body>
    <h1>{{ __('appointments.makeappointment') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="date">{{ __('appointments.date') }}</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
        </div>

        <div class="form-group">
            <label for="time">{{ __('appointments.time') }}</label>
            <input type="time" class="form-control" id="time" name="time" value="{{ old('time') }}" required>
        </div>
        <div class="form-group">
            <label for="doctor">{{ __('appointments.selectdoctor') }}</label>
            <select id="doctor" name="doctor_id" required>
                <option value="">{{ __('appointments.selectdoctor') }}</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }}, {{ $doctor->profession->name }}, {{ $doctor->subsidiary->naming }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Add any additional appointment fields as needed -->

        <button type="submit">{{ __('appointments.create') }}</button>
    </form>
</body>

</html>