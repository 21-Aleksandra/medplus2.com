<h1>Comments</h1>
    <form action="{{ route('comments.delete') }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
        <table>
            <script>

function confirmDelete() {
    var selectedComments = [];
    var checkboxes = document.querySelectorAll('input[name="selected_comments[]"]:checked');

    if (checkboxes.length === 0) {
        alert("Please select at least one comment to delete.");
        return;
    }

    checkboxes.forEach(function (checkbox) {
        var commentId = checkbox.value;
        selectedComments.push(commentId);
    });

    if (confirm("Are you sure you want to delete the following comments:\n" + selectedComments.join(", ") + "?")) {
        document.getElementById('deleteForm').submit();
    }
}
</script>

     
            <thead>
                <tr>
                <th>Delete</th>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Doctor id</th>
                    <th>Doctor</th>
                    <th>Comment</th>
                  
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <tr>
                <td>
                        <input type="checkbox" name="selected_comments[]" value="{{ $comment->id }}">
                    </td>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->user ? $comment->user->name : 'Unknown' }}</td>
                    <td>{{ $comment->doctor ? $comment->doctor->id : 'Unknown' }}</td>
                    <td>{{ $comment->doctor ? $comment->doctor->name : 'Unknown' }}</td>
                    <td>{{ $comment->text }}</td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" onclick="confirmDelete()">Delete selected</button>
    </form>
    <a href="{{ url('/dashboard') }}">Go to Homepage aka Dash</a>
</body>
</html>