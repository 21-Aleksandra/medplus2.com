<?php
namespace App\Http\Controllers;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Mail\ChangeMail;
use App\Mail\ManagerMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    if(Gate::allows('is_admin')){
        abort(403);
    }
    $userRole = Auth::user()->role;
    $userAppointments = [];
    $managerAppointments = [];

    if ($userRole === 0) {
        $userAppointments = Appointment::where('user_id', Auth::user()->id)->get();
    } elseif ($userRole === 1) {
        $managerId = Auth::user()->id;
        $managerAppointments = Appointment::whereHas('doctor', function ($query) use ($managerId) {
            $query->whereHas('subsidiary', function ($query) use ($managerId) {
                $query->where('manager_id', $managerId);
            });
        })->get();
    }

    return view('viewappoitment', compact('userRole', 'userAppointments', 'managerAppointments'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('is_user')){
        
       
        $doctors = Doctor::all();
        
        return view('makeappointment', compact('doctors'));}

        else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Gate::allows('is_admin')){
            abort(403);}

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);
    
        $appointment = new Appointment();
        $appointment->user_id = auth()->user()->id; // Assuming you have an authenticated user
        $appointment->doctor_id = $request->doctor_id;
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->status = 'waiting'; // Set the default status
        $appointment->save();
    
        return redirect('/profile')->with('success', 'Appointment created successfully.');
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
    public function update(Appointment $appointment, Request $request)
    {
        if(Gate::allows('is_user')){

        $action = $request->input('action');
    
        if ($action === 'accept') {
            $appointment->status = 'accepted';
        } elseif ($action === 'decline') {
            $appointment->status = 'declined';
    
            // Send email to user with role 1 (manager)
            Mail::to($appointment->user->email)->send(new ManagerMail($appointment));
        }
    
        $appointment->save();
    
        return redirect()->route('appointments.index')->with('success', 'Appointment status updated successfully.');
    }
        else{
            abort(403);
        }

    }

public function updateStatus(Request $request)

{
    if(Gate::allows('is_manager')){
    $selectedAppointments = $request->input('selectedAppointments');
    $action = $request->input('action');

    if ($action === 'accept') {
        Appointment::whereIn('id', $selectedAppointments)->update(['status' => 'accepted']);
    } elseif ($action === 'decline') {
        Appointment::whereIn('id', $selectedAppointments)->update(['status' => 'declined']);
    }

    // Send emails to users
    $appointments = Appointment::whereIn('id', $selectedAppointments)->get();
    foreach ($appointments as $appointment) {
        $user = $appointment->user;
        Mail::to($user->email)->send(new ChangeMail($appointment));
    }
  

    return redirect()->route('appointments.index')->with('success', 'Selected appointments status updated successfully.');
}
else{
    abort(403);
}
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
