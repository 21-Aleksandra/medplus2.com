<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
</head>
<body>
    <h1>Doctor Details</h1>
    
    <div>
 


        @if ($doctor)
            <h2>{{ $doctor->name }}</h2>
            <p>Gender: {{ $doctor->gender }}</p>
            <p>Profession: {{ $doctor->profession->name }}</p>
            <!-- Display other relevant doctor information -->

            <h3>Languages:</h3>
            <ul>
                @forelse ($doctor->languages as $language)
                    <li>{{ $language->code }}</li>
                @empty
                    <li>No languages found.</li>
                @endforelse
            </ul>

            @can('is_user')
            <h3>Leave a Comment</h3>
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
                <textarea name="text" id="commentText" rows="4" cols="50" placeholder="Enter your comment(max = 400 symbols)"></textarea>
                <br>
                <button type="submit" onclick="return confirm('Are you sure you want to save this comment?')">Save</button>
            </form>
            @endcan

            <div id="characterCountMessage" style="display: none;">
                <p> You have entered more than 400!!!</p>
            </div>

            <h3>Comments</h3>
            @foreach ($comments as $comment)
                <p>Author: {{ $comment->user->name }}</p>
                <p>{{ $comment->text }}</p>
                <hr>
            @endforeach

           

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

    <a href="{{ url('/doctors') }}">Go to doctor list</a>
</body>
</html>