<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', '!=', 2)->get();
    
        return view('users', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adduser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:0,1,2,3',
        ]);
    
        // Create a new user with the validated data
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = ($validatedData['password']);
        $user->role = $validatedData['role'];
        $user->save();
    
        // Redirect back to the users page
        return redirect('/users');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {$user = User::findOrFail($user);
        return view('edituser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|in:0,1,2,3',
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->filled('password')) {
            $user->password = $request->password;
        }
    
        $user->role = $request->role;
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function actions(Request $request)
    {
        $action = $request->input('action');
        $userIds = $request->input('users', []);

        if ($action === 'ban') {
            // Ban selected users
            foreach ($userIds as $userId) {
                $user = User::findOrFail($userId);
                $user->role = 3; // Assuming 'role' is the column to store the user role
                $user->save();
            }
            
            return redirect()->back()->with('success', 'Selected users have been banned.');
        } elseif ($action === 'delete') {
            // Delete selected users
            $deletedUsers = User::whereIn('id', $userIds)->delete();
            
            return redirect()->back()->with('success', 'Selected users have been deleted.');
        } elseif ($action === 'edit') {
            if (count($userIds) !== 1) {
                return redirect()->back()->with('error', 'Please select one user to edit.');
            }
            $selectedUserId = $userIds[0];

            // Redirect to the edit route for the selected user
            return redirect()->route('users.edit', ['user' => $selectedUserId]);
        }

        return redirect()->back()->with('error', 'Invalid action.');
    }
}