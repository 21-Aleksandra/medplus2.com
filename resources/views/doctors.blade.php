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
    @can('is_manager')
   
       
        <button type="button" onclick="confirmDelete()">{{__('doctors.delsel') }}</button>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">{{__('doctors.add') }}</a>
  


 

        <button type="button" onclick="editSelected()">{{__('doctors.editsel') }}</button>
   

    </div>
    @endcan
    @if ($doctors->isEmpty())
    <div>No doctors found.</div>
    @endif

    @foreach($doctors as $doctor)
    @if (!auth()->guest() && auth()->user()->can('is_manager') && $doctor->subsidiary && auth()->user()->id === $doctor->subsidiary->manager_id)
        {{-- Show only doctors from manager's subsidiary for manager role --}}
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
            <span>
        @if ($doctor->photo_id)
            <img src="{{ asset('images/'.$doctor->photo->name) }}" alt="Doctor Photo" width="100" height="100">
        @else
            <img src="{{ asset('images/default.jpg') }}" alt="Default Photo" width="100" height="100">
        @endif
    </span>
        </div>
    @elseif (auth()->guest() || (auth()->user()->can('is_admin') || auth()->user()->can('is_user')))
        <div>
            @can('is_manager')
            <input type="checkbox" name="selected_doctors[]" value="{{ $doctor->id }}">
            @endcan
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
            <span>
        @if ($doctor->photo_id)
            <img src="{{ asset('images/'.$doctor->photo->name) }}" alt="Doctor Photo" width="100" height="100">
        @else
            <img src="{{ asset('images/default.jpg') }}" alt="Default Photo" width="100" height="100">
        @endif
    </span>
        </div>
    @endif
@endforeach

    <button type="submit" style="display: none;">Delete</button>
</form>
<script>
   


function editSelected() {
    var checkboxes = document.querySelectorAll('input[name="selected_doctors[]"]:checked');
    var selectedCount = checkboxes.length;

    if (selectedCount === 0) {
        alert("{{__('doctors.aledit') }}");
    } else if (selectedCount > 1) {
        alert("{{__('doctors.aleditone') }}");
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
        alert("{{__('doctors.aldel') }}");
        return;
    }

    checkboxes.forEach(function (checkbox) {
        var doctorName = checkbox.nextElementSibling.textContent;
        selectedDoctors.push(doctorName);
    });

    if (confirm("{{__('doctors.aldelsure') }}:\n" + selectedDoctors.join(", ") + "?")) {
        document.getElementById('deleteForm').submit();
    }
}
</script>

@canany(['is_admin', 'is_user', 'is_manager'])
<br>
<a href="{{ url('/dashboard') }}">Go to Homepage aka Dash</a>

@endcanany 

<br>
@guest

<a href="{{ url('/') }}">Go to Main Page aka Guest</a>
@endguest



<form action="{{ route('doctor.search') }}" method="POST">
@method('POST')
    @csrf

    <div>
        <label for="name">{{__('doctors.name') }}</label>
        <input type="text" id="name" name="name" value="{{ request('name') }}" placeholder="{{__('doctors.enter') }}">
    </div>

    <div>
        <label for="profession">{{__('doctors.profession') }}</label>
        <select id="profession" name="profession">
            <option value="">{{__('doctors.allprof') }}</option>
            @foreach ($professions as $profession)
                <option value="{{ $profession->id }}" {{ request('profession') == $profession->id ? 'selected' : '' }}>
                    {{ $profession->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="subsidiary">{{__('doctors.subsidiary') }}</label>
        <select id="subsidiary" name="subsidiary">
            <option value="">{{__('doctors.allsub') }}</option>
            @foreach ($subsidiaries as $subsidiary)
    @can('is_manager')
        @if ($subsidiary->manager_id == Auth::user()->id)
            <option value="{{ $subsidiary->id }}" {{ request('subsidiary') == $subsidiary->id ? 'selected' : '' }}>
                {{ $subsidiary->naming }}
            </option>
        @endif
    @else
        <option value="{{ $subsidiary->id }}" {{ request('subsidiary') == $subsidiary->id ? 'selected' : '' }}>
            {{ $subsidiary->naming }}
        </option>
    @endcan
@endforeach
        </select>
    </div>

    <div>
        <label for="gender">{{__('doctors.gender') }}:</label>
        <select name="gender" id="gender">
        <option value="">{{__('doctors.any') }}</option>
            <option value="Male">{{__('doctors.male') }}</option>
            <option value="Female">{{__('doctors.female') }}</option>
        </select>
    </div>


    <div>
        <label>{{__('doctors.languages') }}:</label>
        @foreach ($languages as $language)
            <div>
                <input type="checkbox" id="{{ $language->id }}" name="languages[]" value="{{ $language->id }}" {{ in_array($language->id, request('languages', [])) ? 'checked' : '' }}>
                <label for="{{ $language->id }}">{{ $language->code }}</label>
            </div>
        @endforeach
    </div>


    <button type="submit">{{__('doctors.search') }}</button>
</form>










</body>
