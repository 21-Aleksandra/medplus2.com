<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Profession;
use App\Models\Language;
use App\Models\Subsidiary;
use Illuminate\Validation\Rule;
use App\Models\Photo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve all doctors
        $query = Doctor::query();
    
        // Apply filters based on search inputs
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }
    
        if ($request->filled('profession')) {
            $query->where('profession_id', $request->input('profession'));
        }
    
        if ($request->filled('subsidiary')) {
            $query->where('subsidiary_id', $request->input('subsidiary'));
        }
    
        if ($request->filled('languages')) {
            $query->whereHas('languages', function ($q) use ($request) {
                $q->whereIn('id', $request->input('languages'));
            });
        }
    
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }
    
        $doctors = $query->get();
    
        // Retrieve all professions, subsidiaries, and languages for the search form
        $professions = Profession::all();
        $subsidiaries = Subsidiary::all();
        $languages = Language::all();
    
        return view('doctors', compact('doctors', 'professions', 'subsidiaries', 'languages'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::denies('is_manager')){
            abort(403);
        }
        $professions = Profession::all();
        $subsidiaries = Subsidiary::all();
        $languages = Language::all();
        return view('adddoc',compact('professions', 'subsidiaries', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('is_manager')) {
            abort(403);
        }
    
        $rules = [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'profession_id' => 'required|exists:professions,id',
            'subsidiary_id' => 'required|exists:subsidiaries,id',
            'phone' => 'required|numeric|digits:8',
            'languages' => 'required|array|exists:languages,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5000', // Updated image validation rules
        ];
    
        $request->validate($rules);
    
        $doctor = new Doctor;
        $doctor->name = $request->input('name');
        $doctor->gender = $request->input('gender');
        $doctor->profession_id = $request->input('profession_id');
        $doctor->subsidiary_id = $request->input('subsidiary_id');
        $doctor->phone = $request->input('phone');
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Generate a unique name for the image
            $currentTimestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $imageName = $currentTimestamp . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            // Store the image in the public/images folder
            $image->move(public_path('images'), $imageName);
    
            // Create a new Photo record
            $photo = new Photo;
            $photo->name = $imageName;
            $photo->save();
    
            // Assign the photo ID to the doctor
            $doctor->photo_id = $photo->id;
        }
    
        $doctor->save();
    
        $doctor->languages()->attach($request->input('languages'), ['created_at' => now(), 'updated_at' => now()]);
        return redirect('/doctors')->with('success', 'Doctor created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show($doctorname)
    {
        $doctorName = urldecode($doctorname);
        $doctor = Doctor::where('name', $doctorName )->first();

        if (!$doctor) {
            abort(404); 
            
        }

        $comments = $doctor->comments()->with('user')->get();

    
        return view('show', compact('doctor', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $doctorname)
    {
        if(Gate::denies('is_manager')){
            abort(403);
        }

      
     
            $doctor = Doctor::where('name', urldecode($doctorname))->first();
        
            if (!$doctor) {
                abort(404); // Doctor not found
            }
        
            $professions = Profession::all();
            $subsidiaries = Subsidiary::all();
            $languages = Language::all();
        
            return view('editdoc', compact('doctor', 'professions', 'subsidiaries', 'languages'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('is_manager')) {
            abort(403);
        }
    
        $rules = [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'profession_id' => 'required|exists:professions,id',
            'subsidiary_id' => 'required|exists:subsidiaries,id',
            'phone' => 'required|numeric|digits:8',
            'languages' => 'required|array|exists:languages,id',
            'image' => 'image|mimes:jpeg,png,jpg|max:5000', 
        ];
    
        $request->validate($rules);
    
        $doctor = Doctor::findOrFail($id);
        $doctor->name = $request->input('name');
        $doctor->gender = $request->input('gender');
        $doctor->profession_id = $request->input('profession_id');
        $doctor->subsidiary_id = $request->input('subsidiary_id');
        $doctor->phone = $request->input('phone');
    
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Generate a unique name for the image
            $currentTimestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $imageName = $currentTimestamp . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            // Store the image in the public/images folder
            $image->move(public_path('images'), $imageName);
    
            // Save the image information in the database
            $photo = new Photo();
            $photo->name = $imageName;
            $photo->save();
    
            // Update the doctor's photo ID
            $doctor->photo_id = $photo->id;
        }
    
        $doctor->languages()->sync($request->input('languages'));
    
        $doctor->save();
    
        return redirect('/doctors')->with('success', 'Doctor updated successfully');
    }

    
    public function delete(Request $request)
    {
        if(Gate::denies('is_manager')){
            abort(403);
;        }
        $selectedDoctors = $request->input('selected_doctors');
    
        // Check if any doctors were selected
        if ($selectedDoctors && is_array($selectedDoctors)) {
            // Delete the selected doctors
            Doctor::whereIn('id', $selectedDoctors)->delete();
    
            // Add any additional logic you need after deleting the doctors
        }
    
        // Redirect back to the doctors list page
        return redirect('/doctors');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
