<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\ComplaintFeedbackUpdated;
use App\Mail\NewComplaintEntry;
use App\Notifications\NewComplaintsEntry;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Notifications\Notifiable;

class ComplaintController extends Controller
{
    public function indexComplaint()
    {
        $user = Auth::user();
        
        if ($user->usertype == 'superadmin' || $user->usertype === 'staff'){
            $complaints = Complaint::all();
        } else {
            $complaints = Complaint::where('user_id', $user->id)->get();
        }
        return view('complaint.index_complaint', compact('complaints'));
    }

    public function mainComplaint(Request $request)
    {
        $status = $request->input('status');
        // dd($request->all());
        $complaints = Complaint::when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })->get();

        return view('complaint.main_complaint', compact('complaints', 'status'));
    }

    public function addComplaint()
    {
        $rooms = Room::all();
        return view('complaint.add_complaint', compact('rooms'));
    }

    public function storeComplaint(Request $request)
    {
        $admins = User::where('usertype', 'admin')->get();
        $staffUsers = User::where('usertype', 'staff')->get();

        $request->validate([
            'complaint_username' => 'required|string|max:255',
            'complaint_type' => 'required',
            'complaint_description' => 'required',
            'complaint_category' => 'required|string|in:other,house_room',
            'complaint_room_name' => [
                $request->complaint_category === 'house_room' ? 'required' : 'nullable',
                'regex:/^[A-Z]{2}\/\d{2}(\/[A-Z])?$/'],
            'complaint_appendix.*' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $complaint = new Complaint();
        $complaint->user_id = Auth::user()->id;
        $complaint->identify_number = $request->complaint_identify_number;
        $complaint->name = $request->complaint_username;
        $complaint->type = ucwords(str_replace('_',' ',$request->complaint_type));
        $complaint->description = $request->complaint_description;
        $complaint->category = $request->complaint_category; // 'house_room' or 'other'
        $complaint->room_name = $request->complaint_room_name; // Room name if applicable

        if ($request->hasFile('complaint_appendix')) {
            $filePath = [];
            foreach ($request->file('complaint_appendix') as $file) {
                $filePath[] = $file->store('complaints', 'public');
            }
            $complaint->appendix = json_encode($filePath); // Store paths as JSON
        }

        $complaint->save();

        $adminEmail = 'admin@example.com'; // change this to actual admin email
        Notification::send($staffUsers, new NewComplaintsEntry($complaint));

        $notification = array(
            'message' => 'Complaint added successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('indexcomplaint')->with($notification);
    }

    public function viewComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('complaint.view_complaint', compact('complaint'));
    }

    public function editComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('complaint.response_complaint', compact('complaint'));
    }

    public function responseComplaint(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'feedback' => 'required|string|max:255',
        ]);

        // Prepare feedback log array
        $existingFeedback = json_decode($complaint->feedback, true) ?? [];

        // Log status update as feedback entry
        if ($request->has('status')) {
            $complaint->status = $request->status;

            $existingFeedback[] = [
                'time' => Carbon::now()->toDateTimeString(),
                'feedback' => 'Status changed to: ' . ucfirst($request->status),
            ];
        }

        // Log manual feedback message
        if ($request->has('feedback')) {
            $existingFeedback[] = [
                'time' => Carbon::now()->toDateTimeString(),
                'feedback' => $request->feedback,
            ];
        }

        $complaint->feedback = json_encode($existingFeedback);
        $complaint->save();

        $user = $complaint->user;
        $user->notify(new ComplaintFeedbackUpdated($complaint));

        $notification = array(
            'message' => 'Complaint response updated successfully',
            'alert-type' => 'success',
        );

        return back()->with($notification);
    }

    public function updateComplaintFeedback(Request $request, $id)
    {
        // Validate feedback
        $request->validate([
            'feedback' => 'required',
        ]);

        // Find the specific complaint
        $complaint = Complaint::with('user')->findOrFail($id);

        // Retrieve existing feedback or initialize an empty array
        $feedback = $complaint->feedback ? json_decode($complaint->feedback, true) : [];

        // Add new feedback entry
        $feedback[] = [
            'feedback' => $request->feedback,
            'time' => now()->toDateTimeString(),
        ];

        // Update the feedback column in the complaint
        $complaint->feedback = json_encode($feedback);

        // Save the complaint
        $complaint->save();

        $notification = array(
            'message' => 'Feedback updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function receiveComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->status = 'in_progress';

        // Log to feedback
        $feedback = json_decode($complaint->feedback, true) ?? [];
        $feedback[] = [
            'time' => Carbon::now()->toDateTimeString(),
            'feedback' => 'Status changed to: In Progress',
        ];
        $complaint->feedback = json_encode($feedback);

        $complaint->save();
        $user = $complaint->user;
        $user->notify(new ComplaintFeedbackUpdated($complaint));

        return back()->with(['success', 'Complaint marked as received']);
    }

    public function completeComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->status = 'completed';

        // Log to feedback
        $feedback = json_decode($complaint->feedback, true) ?? [];
        $feedback[] = [
            'time' => Carbon::now()->toDateTimeString(),
            'feedback' => 'Status changed to: Completed',
        ];
        $complaint->feedback = json_encode($feedback);

        $complaint->save();
        $user = $complaint->user;
        $user->notify(new ComplaintFeedbackUpdated($complaint));

        return back()->with(['success', 'Complaint marked as completed']);
    }

    public function downloadComplaintPDF($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.complaint_form', compact('complaint'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('complaint_' . $complaint->identify_number . '.pdf');
    }
    
    public function deleteComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();

        $notification = array(
            'message'=>'Complaint deleted successfully',
            'alert-type'=>'info'
        );
        return redirect()->back()->with($notification);
    }
}
