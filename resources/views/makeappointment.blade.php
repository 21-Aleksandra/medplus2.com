<!DOCTYPE html>
<html>

<head>
    <title>Make Appointment here</title>
</head>

<body>
    <h1>Make Appointment here!</h1>

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
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
        </div>

        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" class="form-control" id="time" name="time" value="{{ old('time') }}" required>
        </div>
        <div class="form-group">
    <label for="doctor">Doctor:</label>
    <select id="doctor" name="doctor_id" required>
        <option value="">Select a doctor</option>
        @foreach ($doctors as $doctor)
        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
        {{ $doctor->name }}, {{ $doctor->profession->name }}, {{ $doctor->subsidiary->naming }}
        </option>
        @endforeach
    </select>
</div>

        <!-- Add any additional appointment fields as needed -->

        <button type="submit">Create Appointment</button>
    </form>
</body>

</html>