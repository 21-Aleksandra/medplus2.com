<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('comments.title') }}</title>
</head>
<body>
    <h1>{{ __('comments.title') }}</h1>
    <form action="{{ route('comments.delete') }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
        <table>
            <script>
                function confirmDelete() {
                    var selectedComments = [];
                    var checkboxes = document.querySelectorAll('input[name="selected_comments[]"]:checked');

                    if (checkboxes.length === 0) {
                        alert("{{ __('comments.select_one_delete') }}");
                        return;
                    }

                    checkboxes.forEach(function (checkbox) {
                        var commentId = checkbox.value;
                        selectedComments.push(commentId);
                    });

                    if (confirm("{{ __('comments.confirm_delete') }}\n" + selectedComments.join(", ") + "?")) {
                        document.getElementById('deleteForm').submit();
                    }
                }
            </script>
            <thead>
                <tr>
                    <th>{{ __('comments.delete') }}</th>
                    <th>{{ __('comments.id') }}</th>
                    <th>{{ __('comments.author') }}</th>
                    <th>{{ __('comments.doctor_id') }}</th>
                    <th>{{ __('comments.doctor') }}</th>
                    <th>{{ __('comments.comment') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_comments[]" value="{{ $comment->id }}">
                        </td>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->user ? $comment->user->name : __('comments.unknown') }}</td>
                        <td>{{ $comment->doctor ? $comment->doctor->id : __('comments.unknown') }}</td>
                        <td>{{ $comment->doctor ? $comment->doctor->name : __('comments.unknown') }}</td>
                        <td>{{ $comment->text }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" onclick="confirmDelete()">{{ __('comments.delete_selected') }}</button>
    </form>
    <a href="{{ url('/dashboard') }}">{{ __('comments.go_to_homepage') }}</a>
</body>
</html>