<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('user', 'doctor')->get();
        $doctors=Doctor::all();

        return view('showcom', compact('comments','doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$doctorname)
    {

  
        $request->validate([
            'text' => 'required|string|max:400',
        ]);

        // Find the doctor by name
        $doctor = Doctor::where('name', $doctorname)->first();

        if (!$doctor) {
            abort(404); // Doctor not found
        }

   
        $comment = new Comment();
        $comment->text = $request->input('text');
        $comment->doctor_id = $doctor->id;
        $comment->user_id = Auth::id();
  
        $comment->save();
    

        
        $url = url('/doctor/' . str_replace(' ', '+', $doctor->name));

        return redirect($url);

    
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $selectedComments = $request->input('selected_comments');
    
        // Check if any comments were selected
        if ($selectedComments && is_array($selectedComments)) {
            // Delete the selected comments
            Comment::whereIn('id', $selectedComments)->delete();
    
            // Add any additional logic you need after deleting the comments
        }
    
        // Redirect back to the comments list page
        return redirect('/comments');
    }
}
