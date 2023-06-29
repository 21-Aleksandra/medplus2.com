<!DOCTYPE html>
<html>
<head>
    <title>{{ __('appointments.title') }}</title>
    <meta charset="utf-8">
    <link rel='stylesheet' href="{{asset('/css/main.css')}}" >
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<section class="centered-content">  
    
@include('layouts.navbar')
<h1 class="apphead">{{ __('appointments.title') }}</h1>
<div class="container">
    <table class="table table-bordered border-bottom-light">
        <thead>
            <tr>
                <th>{{ __('appointments.table.date') }}</th>
                <th>{{ __('appointments.table.time') }}</th>
                <th>{{ __('appointments.table.doctor') }}</th>
                <th>{{ __('appointments.table.status') }}</th>
                @can('is_user')
                    <th>{{ __('appointments.table.action') }}</th>
                @endcan
                @can('is_manager')
                    <th>{{ __('appointments.table.select') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @can('is_user')
                @forelse ($userAppointments as $appointment)
                @if (!isset($appointment->doctor->name))
        @php
            $appointment->status = 'declined';
            $appointment->save();
        @endphp
    @endif 
                    <tr>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>{{ $appointment->doctor->name ?? __('appointments.deldata') }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>
                            @if ($appointment->status !== 'declined' && isset($appointment->doctor->name))
                                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="decline" class="btn btn-danger rounded" onclick="return confirm('{{ __('appointments.decline.confirmation') }} {{ $appointment->doctor->name }}?')">{{ __('appointments.decline') }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">{{ __('appointments.noappointments') }}</td>
                    </tr>
                @endforelse
            @endcan

            @can('is_manager')
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
                                    <input  class='bestcheck'type="checkbox" name="selectedAppointments[]" value="{{ $appointment->id }}">
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
                                <button type="submit" name="action" value="decline" class="btn btn-danger rounded" onclick="return confirmDeclineAll()">{{ __('appointments.declineselect') }}</button>
                                <button type="submit" name="action" value="accept" class="btn btn-danger rounded" onclick="return confirmAcceptAll()">{{ __('appointments.acceptselect') }}</button>
                            </td>
                        </tr>
                    </tfoot>
                </form>
            @endcan
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

    </section>
</body>
</html>