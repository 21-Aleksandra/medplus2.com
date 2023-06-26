<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Profession;
use App\Models\Language;
use App\Models\Subsidiary;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        $rules = [
            'name' => 'required|string|max:255|unique:doctors,name',
            'gender' => 'required|in:Male,Female',
            'profession_id' => 'required|exists:professions,id',
            'subsidiary_id' => 'required|exists:subsidiaries,id',
            'phone' => 'required|numeric|digits:8|min:1000000',
            'languages' => 'required|array|exists:languages,id',
            // Add validation rules for other fields
        ];
    
        $request->validate($rules);
    
        $doctor = new Doctor($request->all());
    
        $doctor->save();
    
        $doctor->languages()->sync($request->input('languages'));
    
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
    $rules = [
        'name' => [
            'required',
            'string',
            'max:255',
          
        ],
        'gender' => 'required|in:Male,Female',
        'profession_id' => 'required|exists:professions,id',
        'subsidiary_id' => 'required|exists:subsidiaries,id',
        'phone' => 'required|numeric|digits:8|min:1000000',
        'languages' => 'required|array|exists:languages,id',
        // Add validation rules for other fields
    ];

    $request->validate($rules);

    $doctor = Doctor::findOrFail($id);

    $doctor->fill($request->all());

    $doctor->save();

    $doctor->languages()->sync($request->input('languages'));

    return redirect('/doctors')->with('success', 'Doctor updated successfully');
}

    
    public function delete(Request $request)
    {
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
