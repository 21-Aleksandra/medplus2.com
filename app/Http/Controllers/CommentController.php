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
        //
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
            'text' => 'required|string',
        ]);

        // Find the doctor by name
        $doctor = Doctor::where('name', $doctorname)->first();

        if (!$doctor) {
            abort(404); // Doctor not found
        }

        // Create a new comment and associate it with the doctor
        $comment = new Comment();
        $comment->text = $request->input('text');
        $comment->doctor_id = $doctor->id;
        $comment->user_id = Auth::id();
        // Add any other relevant fields to the comment

        // Save the comment
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
    public function destroy(string $id)
    {
        //
    }
}
