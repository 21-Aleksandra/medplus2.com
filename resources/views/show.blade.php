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

            <h3>Comments</h3>
            @foreach ($comments as $comment)
                <p>Author: {{ $comment->user->name }}</p>
                <p>{{ $comment->text }}</p>
                <hr>
            @endforeach

            <h3>Leave a Comment</h3>
            <form method="POST" action="{{ route('comments.store', ['doctorname' => $doctor->name]) }}">
                @csrf
                <textarea name="text" rows="4" cols="50" placeholder="Enter your comment" ></textarea>
                <br>
                <button type="submit"  onclick="return confirm('Are you sure you want to save this comment?')">Save</button>
            </form>

        @else
            <p>Doctor not found.</p>
        @endif

        
    </div>
    <a href="{{ url('/doctors') }}">Go to doctor list</a>
</body>
</html>