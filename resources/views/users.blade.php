<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel='stylesheet' href="{{asset('/css/main.css')}}" >
    <title>Users</title>
</head>
<body>
<section class="centered-content">
@include('layouts.navbar')
    <h1 class="heading">{{ __('user.title') }}</h1>
    <form action="{{ route('users.actions') }}" method="POST" id="userActionsForm" class="table-form">
        @csrf
        <div class="content-wrapper">
        <table class="table table-bordered  table-custom">
            <thead>
                <tr>
                    <th>{{ __('user.id') }}</th>
                    <th>{{ __('user.name') }}</th>
                    <th>{{ __('user.email') }}</th>
                    <th>{{ __('user.role') }}</th>
                    <th>{{ __('user.ban') }}</th>
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
                      
                        <input class='bestcheck' type="checkbox" name="users[]" value="{{ $user->id }}" data-username="{{ $user->name }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class='action-box '>
        <div class="action-buttons">
        <h1>{{__('doctors.actions') }}</h1>
        <button class="btn btn-danger rounded"><a id="nostileno" href="{{ route('users.create') }}" >{{ __('user.add_user') }}</a></button>
        <button type="button" onclick="confirmActions('ban')" class="btn btn-danger rounded">{{ __('user.ban') }}</button>
        <button type="button" onclick="confirmActions('delete')" class="btn btn-danger rounded">{{ __('user.delete_users') }}</button>
        <button type="button" onclick="confirmActions('edit')" class="btn btn-danger rounded">{{ __('user.edit_user') }}</button>
        </div>
        </div>
    </form>

    <script>
        function confirmActions(action) {
            var selectedUsers = [];
            var checkboxes = document.querySelectorAll('input[name="users[]"]:checked');

            if (checkboxes.length === 0) {
                alert("{{ __('user.select_at_least_one_user') }}");
                return;
            }

            checkboxes.forEach(function (checkbox) {
                var userId = checkbox.value;
                var userName = checkbox.dataset.username;
                selectedUsers.push({ id: userId, name: userName });
            });

            var confirmationMessage = "Are you sure you want to " + action + " the following users?\n\n";
            selectedUsers.forEach(function (user) {
                confirmationMessage += "{{ __('user.id') }}: " + user.id + " - {{ __('user.name') }}: " + user.name + "\n";
            });

            if (action === 'edit') {
                if (selectedUsers.length !== 1) {
                    alert("{{ __('user.select_one_user_edit') }}");
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
    </script>
    </div>
</section>
</body>
</html>