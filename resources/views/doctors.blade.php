<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctors</title>
</head>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Profession</th>
            <th>Language</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
            <tr>
            @php
            $encodedName = urlencode($doctor->name);
            @endphp
                <td> <a href="{{ route('doctor.show', $encodedName) }}">{{ $doctor->name }}</a></td>
                <td>{{ $doctor->gender }}</td>
                <td>{{ $doctor->profession->name }}</td>
                <td>
                          @forelse ($doctor->languages as $language)
                   {{ $language->code }},
                @empty
                    <li>No languages found.</li>
                @endforelse</td>
            </tr>
        @endforeach
    </tbody>

</table>
<a href="{{ url('/dashboard') }}">Go to Homepage aka Dash</a>
<br>
<a href="{{ url('/') }}">Go to Main Page aka Guest</a>