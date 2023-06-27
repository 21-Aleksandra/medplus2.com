<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Appointments</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    @if ($userRole === 0)
                        <th>Action</th>
                    @elseif ($userRole === 1)
                        <th>Select</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($userRole === 0)
                    <!-- Display appointments for role 0 (user) -->
                    @forelse ($userAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->status }}</td>
                            <td>
                                @if ($appointment->status !=='declined')
                                   <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <button type="submit" name="action" value="decline" class="btn btn-danger" onclick="return confirm('Are you sure you want to decline your visit to {{ $appointment->doctor->name }}?')">Decline</button>
</form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No appointments found.</td>
                        </tr>
                    @endforelse
                @elseif ($userRole === 1)
                    <!-- Display appointments for role 1 (manager) -->
                    <form action="{{ route('appointments.updateStatus') }}" method="POST">
                        @csrf
                        <tbody>
                            @forelse ($managerAppointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->status }}</td>
                                    <td>
                                        <input type="checkbox" name="selectedAppointments[]" value="{{ $appointment->id }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                <button type="submit" name="action" value="decline" class="btn btn-danger" onclick="return confirm('Are you sure you want to decline all selected visit?')">Decline selected</button>
                                <button type="submit" name="action" value="accept" class="btn btn-danger" onclick="return confirm('Are you sure you want to accept all selected visit ?')">Accept selected</button>
                                </td>
                            </tr>
                        </tfoot>
                    </form>
                @endif
            </tbody>
        </table>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <a href="{{ url('/dashboard') }}">Go to Homepage aka Dash</a>
</body>
</html>