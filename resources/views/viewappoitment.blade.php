<!DOCTYPE html>
<html>
<head>
    <title>{{ __('appointments.title') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>{{ __('appointments.title') }}</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('appointments.table.date') }}</th>
                    <th>{{ __('appointments.table.time') }}</th>
                    <th>{{ __('appointments.table.doctor') }}</th>
                    <th>{{ __('appointments.table.status') }}</th>
                    @if ($userRole === 0)
                        <th>{{ __('appointments.table.action') }}</th>
                    @elseif ($userRole === 1)
                        <th>{{ __('appointments.table.select') }}</th>
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
                                @if ($appointment->status !== 'declined')
                                    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="decline" class="btn btn-danger" onclick="return confirm('{{ __('appointments.decline.confirmation') }} {{ $appointment->doctor->name }}?')">{{ __('appointments.decline') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">{{ __('appointments.noappointments') }}</td>
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
                                    <td colspan="5">{{ __('appointments.noappointments') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                            <td colspan="5">
    <button type="submit" name="action" value="decline" class="btn btn-danger" onclick="return confirmDeclineAll()">{{ __('appointments.declineselect') }}</button>
    <button type="submit" name="action" value="accept" class="btn btn-danger" onclick="return confirmAcceptAll()">{{ __('appointments.acceptselect') }}</button>
</td>
                            </tr>
                        </tfoot>
                    </form>
                @endif
            </tbody>
        </table>
    </div>

<script>
    function confirmDeclineAll() {
        return confirm("{{ __('appointments.declineall.confirmation') }}");
    }

    function confirmAcceptAll() {
        return confirm("{{ __('appointments.acceptall.confirmation') }}");
    }


</script>
    <script src="{{ asset('js/app.js') }}"></script>
    <a href="{{ url('/dashboard') }}">Go to Homepage aka Dash</a>
</body>
</html>