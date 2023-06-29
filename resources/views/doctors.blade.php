<!DOCTYPE html>
<html >

<head>
    <meta charset="UTF-8">
    <link rel='stylesheet' href="{{asset('/css/main.css')}}" >
    <title>Doctors</title>
</head>
<section class="centered-content">
@canany(['is_user', 'is_manager', 'is_admin'])
@include('layouts.navbar')
@endcanany

@guest
@include('layouts.navbarguest')
@endguest

<body>


<div class="searchdiv">
    <h1>{{__('doctors.serachdiv') }}</h1>
    <form action="{{ route('doctor.search') }}" method="POST">
        @method('POST')
        @csrf

        <div class="form-group" >
            <label for="name">{{__('doctors.name') }}</label>
            <input type="text" id="name" name="name" value="{{ request('name') }}" placeholder="{{__('doctors.enter') }}">
        </div>


        <div class="form-group">
            <label  for="profession">{{__('doctors.profession') }}</label>
            <select id="profession" name="profession">
                <option value="">{{__('doctors.allprof') }}</option>
                @foreach ($professions as $profession)
                    <option value="{{ $profession->id }}" {{ request('profession') == $profession->id ? 'selected' : '' }}>
                        {{ $profession->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
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
                            {{ $subsidiary->naming }}, {{ $subsidiary->address->city }}, {{ $subsidiary->address->street }}
                        </option>
                    @endcan
                @endforeach
            </select>

   

        <div class="form-group">
            <label for="gender">{{__('doctors.gender') }}:</label>
            <select name="gender" id="gender">
                <option value="">{{__('doctors.any') }}</option>
                <option value="Male">{{__('doctors.male') }}</option>
                <option value="Female">{{__('doctors.female') }}</option>
            </select>
        </div>

        <div class="form-group">
            <label>{{__('doctors.languages') }}:</label>
            @foreach ($languages as $language)
                <div>
                    <input type="checkbox" id="{{ $language->id }}" name="languages[]" value="{{ $language->id }}" {{ in_array($language->id, request('languages', [])) ? 'checked' : '' }}>
                    <label for="{{ $language->id }}">{{ $language->code }}</label>
                </div>
            @endforeach
      
        </div>

        <button class='super' type="submit">{{__('doctors.search') }}</button>
    </form>
    @can('is_manager')
    <div class='actiondiv'>
    <h1>{{__('doctors.actions') }}</h1>
    <button type="button" onclick="confirmDelete()">{{__('doctors.delsel') }}</button>
        <button><a href="{{ route('doctors.create') }}" class="btn btn-primary">{{__('doctors.add') }}</a></button>
        <button type="button" onclick="editSelected()">{{__('doctors.editsel') }}</button>
       </div>
@endcan     
</div>

</div>


     
<script>
   


   function editSelected() {
    var checkboxes = document.querySelectorAll('input[name="selected_doctors[]"]:checked');
    var selectedCount = checkboxes.length;

    if (selectedCount === 0) {
        alert("{{__('doctors.aledit') }}");
    } else if (selectedCount > 1) {
        alert("{{__('doctors.aleditone') }}");
    } else {
        var selectedDoctorId = checkboxes[0].value;
        window.location.href = "{{ url('/doctors/') }}/" + selectedDoctorId + "/edit";
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
<div class="stilediv">
    <form id="deleteForm" method="POST" action="{{ route('doctors.delete') }}">
        @csrf
        @method('DELETE')
        <div class="doctor-list">
            @if ($doctors->isEmpty())
                <div>No doctors found.</div>
            @endif

            @foreach($doctors as $doctor)
                @if (!auth()->guest() && auth()->user()->can('is_manager') && $doctor->subsidiary && auth()->user()->id === $doctor->subsidiary->manager_id)
                    <div class="doctor-card">
                        @can('is_manager')
                            <input class='bestcheck' type="checkbox" name="selected_doctors[]" value="{{ $doctor->id }}">
                        @endcan
                        <span><a href="{{ route('doctor.show', $doctor->id) }}">{{ $doctor->name }}</a></span>
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
                                @php
                                    $photo = App\Models\Photo::where('id', $doctor->photo_id)->whereNotNull('id')->first();
                                @endphp
                                @if ($photo)
                                    <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/' . $photo->name) }}" alt="Doctor Photo" width="100" height="100"></a>
                                @else
                                    <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/default.jpg') }}" alt="Default Photo" width="100" height="100"></a>
                                @endif
                            @else
                                <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/default.jpg') }}" alt="Default Photo" width="100" height="100"></a>
                            @endif
                        </span>
                    </div>
                @elseif (auth()->guest() || (auth()->user()->can('is_admin') || auth()->user()->can('is_user')))
                    <div class="doctor-card">
                        @can('is_manager')
                            <input type="checkbox" name="selected_doctors[]" value="{{ $doctor->id }}">
                        @endcan
                        <span><a href="{{ route('doctor.show', $doctor->id) }}">{{ $doctor->name }}</a></span>
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
                                @php
                                    $photo = App\Models\Photo::where('id', $doctor->photo_id)->whereNotNull('id')->first();
                                @endphp
                                @if ($photo)
                                    <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/' . $photo->name) }}" alt="Doctor Photo" width="100" height="100"></a>
                                @else
                                    <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/default.jpg') }}" alt="Default Photo" width="100" height="100"></a>
                                @endif
                            @else
                                <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/default.jpg') }}" alt="Default Photo" width="100" height="100"></a>
                            @endif
                        </span>
                    </div>
                @endif
            @endforeach

            <button type="submit" style="display: none;">Delete</button>
        </div>
    </form>
</div>


</section>
</body>

</html>
