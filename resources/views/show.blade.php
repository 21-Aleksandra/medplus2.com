<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel='stylesheet' href="{{asset('/css/main.css')}}" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
</head>
<body>
<section class="centered-content">    
@canany(['is_user', 'is_manager', 'is_admin'])
@include('layouts.navbar')
@endcanany

@guest
@include('layouts.navbarguest')
@endguest
<div class="showdoc">
 

    <h1>{{__('doctors.detail') }}</h1>
    



        @if ($doctor)
            <h2>{{ $doctor->name }}</h2>
            <span>
                            @if ($doctor->photo_id)
                                @php
                                    $photo = App\Models\Photo::where('id', $doctor->photo_id)->whereNotNull('id')->first();
                                @endphp
                                @if ($photo)
                                    <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/' . $photo->name) }}" alt="Doctor Photo" ></a>
                                @else
                                    <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/default.jpg') }}" alt="Default Photo" ></a>
                                @endif
                            @else
                                <a href="{{ route('doctor.show', $doctor->id) }}"><img src="{{ asset('images/default.jpg') }}" alt="Default Photo"></a>
                            @endif
                        </span>
            <div class='infodoc aka'>
            <p> {{ $doctor->subsidiary->naming }}</p>
            <p> {{ $doctor->profession->name }}</p>
         

            <div class='p'>
            @forelse ($doctor->languages as $key => $language)
                                {{ $language->code }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @empty
                                No languages found.
                            @endforelse
                </div>   
</div>
     

            @can('is_user')
            <h3 class="leavecomhere">{{__('doctors.leave') }}</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

          
            <form method="POST" action="{{ route('comments.store', ['doctorname' => $doctor->name]) }}">
                @csrf
                <textarea name="text" id="commentText" rows="4" cols="50" placeholder="Enter your comment(max = 400 symbols)"class="custom-textarea" ></textarea>
                <br>
                <button type="submit" onclick="return confirm('Are you sure you want to save this comment?')">Save</button>
            </form>
            @endcan

            <div id="characterCountMessage" style="display: none;">
                <p> {{__('doctors.hund') }}</p>
            </div>

            <div class="com top">
    <h3>{{__('doctors.comments') }}</h3>
    @if ($comments->isEmpty())
        <p>{{__('doctors.nocomments') }}</p>
    @else
        @foreach ($comments as $comment)
            <p>{{__('doctors.author') }}: {{ $comment->user->name }}</p>
            <p>{{ $comment->text }}</p>
            <hr>
        @endforeach
    @endif
</div>

            <script>
                var inputElement = document.getElementById('commentText');
                var characterCountMessage = document.getElementById('characterCountMessage');

                inputElement.addEventListener('input', function() {
                    var inputText = inputElement.value;
                    var count = inputText.length;

                    if (count > 400) {
                        characterCountMessage.style.display = 'block';
                    } else {
                        characterCountMessage.style.display = 'none';
                    }
                });
            </script>

        @else
            <p>Doctor not found.</p>
        @endif
    </div>



</section>
</body>

</html>