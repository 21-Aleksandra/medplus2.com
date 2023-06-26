<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctors</title>
</head>

<body>


<form id="deleteForm" method="POST" action="{{ route('doctors.delete') }}">
    @csrf
    @method('DELETE')

    <div>
        <button type="button" onclick="editSelected()">Edit Selected</button>
        <button type="button" onclick="confirmDelete()">Delete Selected</button>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add Doctor</a>
    </div>

    @if ($doctors->isEmpty())
    <div>No doctors found.</div>
    @endif

    @foreach($doctors as $doctor)
    
    <div>
        <input type="checkbox" name="selected_doctors[]" value="{{ $doctor->id }}">
    @php
    $encodedName = urlencode($doctor->name);
    @endphp
        <span><a href="{{ route('doctor.show', $encodedName) }}">{{ $doctor->name }}</a></span>
        <span>{{ $doctor->profession->name }}</span>
        <span>
    @forelse ($doctor->languages as $key => $language)
        {{ $language->code }}
        @if (!$loop->last)
        ,
        @endif
    @empty
        No languages found.
    @endforelse
</span>
    </div>
    @endforeach

    <button type="submit" style="display: none;">Delete</button>
</form>

<script>
   


function editSelected() {
    var checkboxes = document.querySelectorAll('input[name="selected_doctors[]"]:checked');
    var selectedCount = checkboxes.length;

    if (selectedCount === 0) {
        alert("Please select a specialist to edit.");
    } else if (selectedCount > 1) {
        alert("Only one specialist can be selected for editing at a time.");
    } else {
        var selectedDoctorName = checkboxes[0].nextElementSibling.textContent;
        var encodedName = encodeURIComponent(selectedDoctorName).replace(/%20/g, '+');
        window.location.href = "{{ url('/doctors/') }}/" + encodedName + "/edit";
    }
}

function confirmDelete() {
    var selectedDoctors = [];
    var checkboxes = document.querySelectorAll('input[name="selected_doctors[]"]:checked');
    
    if (checkboxes.length === 0) {
        alert("Please select at least one doctor to delete.");
        return;
    }

    checkboxes.forEach(function (checkbox) {
        var doctorName = checkbox.nextElementSibling.textContent;
        selectedDoctors.push(doctorName);
    });

    if (confirm("Are you sure you want to delete the following doctors:\n" + selectedDoctors.join(", ") + "?")) {
        document.getElementById('deleteForm').submit();
    }
}
</script>


<a href="{{ url('/dashboard') }}">Go to Homepage aka Dash</a>
<br>

<br>
<a href="{{ url('/') }}">Go to Main Page aka Guest</a>



<form action="{{ route('doctor.search') }}" method="POST">
@method('POST')
    @csrf

    <div>
        <label for="name">Doctor's Name:</label>
        <input type="text" id="name" name="name" value="{{ request('name') }}" placeholder="Enter doctor's name">
    </div>

    <div>
        <label for="profession">Profession:</label>
        <select id="profession" name="profession">
            <option value="">All Professions</option>
            @foreach ($professions as $profession)
                <option value="{{ $profession->id }}" {{ request('profession') == $profession->id ? 'selected' : '' }}>
                    {{ $profession->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="subsidiary">Subsidiary:</label>
        <select id="subsidiary" name="subsidiary">
            <option value="">All Subsidiaries</option>
            @foreach ($subsidiaries as $subsidiary)
                <option value="{{ $subsidiary->id }}" {{ request('subsidiary') == $subsidiary->id ? 'selected' : '' }}>
                    {{ $subsidiary->naming }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="gender">Gender:</label>
        <select name="gender" id="gender">
        <option value="">Any</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>


    <div>
        <label>Languages:</label>
        @foreach ($languages as $language)
            <div>
                <input type="checkbox" id="{{ $language->id }}" name="languages[]" value="{{ $language->id }}" {{ in_array($language->id, request('languages', [])) ? 'checked' : '' }}>
                <label for="{{ $language->id }}">{{ $language->name }}</label>
            </div>
        @endforeach
    </div>


    <button type="submit">Search</button>
</form>










</body>