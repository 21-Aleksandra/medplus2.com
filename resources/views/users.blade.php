<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
</head>
<body>
    <h1>Delete Users</h1>
    <form action="{{ route('users.actions') }}" method="POST" id="userActionsForm">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Ban</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <!-- Ban Checkbox -->
                        <input type="checkbox" name="users[]" value="{{ $user->id }}" data-username="{{ $user->name }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Action Buttons -->
        <button type="button" onclick="confirmActions('ban')">Ban Selected Users</button>
        <button type="button" onclick="confirmActions('delete')">Delete Selected Users</button>
        <button type="button" onclick="confirmActions('edit')">Edit Selected Users</button>
    </form>

    <script>
        function confirmActions(action) {
            var selectedUsers = [];
            var checkboxes = document.querySelectorAll('input[name="users[]"]:checked');

            if (checkboxes.length === 0) {
                alert("Please select at least one user.");
                return;
            }

            checkboxes.forEach(function (checkbox) {
                var userId = checkbox.value;
                var userName = checkbox.dataset.username;
                selectedUsers.push({ id: userId, name: userName });
            });

            var confirmationMessage = "Are you sure you want to " + action + " the following users?\n\n";
            selectedUsers.forEach(function (user) {
                confirmationMessage += "ID: " + user.id + " - Name: " + user.name + "\n";
            });

            if (action === 'edit') {
                if (selectedUsers.length !== 1) {
                    alert("Please select one user to edit.");
                    return;
                }
                var selectedUserId = selectedUsers[0].id;
                window.location.href = "{{ url('/users/') }}/" + selectedUserId + "/edit";
            } else {
                if (confirm(confirmationMessage)) {
                    var actionInput = document.createElement('input');
                    actionInput.setAttribute('type', 'hidden');
                    actionInput.setAttribute('name', 'action');
                    actionInput.setAttribute('value', action);
                    document.getElementById('userActionsForm').appendChild(actionInput);

                    document.getElementById('userActionsForm').submit();
                }
            }
        }
    </script>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a><br>
    <a href="{{ url('/dashboard') }}">Go to Homepage aka Dash</a>
</body>
</html>