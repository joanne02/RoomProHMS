<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\ApplicationSession;
use App\Models\Semester;
use Carbon\Carbon;

class ApplicationSessionController extends Controller
{
    public function mainApplicationSession()
    {
        $session_lists = ApplicationSession::all();
        return view('application_session.main_application_session', compact('session_lists'));
    }

    public function addApplicationSession()
    {
        $semesters = Semester::all();
        return view('application_session.add_application_session', compact('semesters'));
    }

    public function storeApplicationSession(Request $request){
        
        $request->validate([
            // 'application_session_semester'=>'required',
            // 'application_session_year'=>'required',
            'application_semester'=>'required',
            'application_session_batch'=>'required',
            // 'semester_start_date'=>'required|date',
            // 'semester_end_date'=>'required|date|after_or_equal:semester_start_date',
            'application_start_date'=>'required|date',
            'application_end_date'=>'required|date|after_or_equal:application_start_date',
            'acceptance_start_date'=>'required|date',
            'acceptance_end_date'=>'required|date|after_or_equal:acceptance_start_date',
        ]);

        $semester = Semester::findOrFail($request->application_semester);
        $application_session = new ApplicationSession();
        // $application_session->semester = $request->application_session_semester;
        // $application_session->year = $request->application_session_year;
        $application_session->application_batch = $request->application_session_batch;
        $application_session->start_date = null;
        $application_session->end_date = null;
        $application_session->application_start_date = $request->application_start_date;
        $application_session->application_end_date = $request->application_end_date;
        $application_session->acceptance_start_date = $request->acceptance_start_date;
        $application_session->acceptance_end_date = $request->acceptance_end_date;

        $application_session->semester_id = $request->application_semester;
        $application_session->session_name = 'Application ' . 
            $semester->name . 
        ' Batch ' . intval($request->application_session_batch);

        $now = now();
        if ($now->between($request->application_start_date, $request->acceptance_end_date)) {
            $application_session->is_active = true;
        } else {
            $application_session->is_active = false;
        }
        $application_session->save();
        
        $notification = array(
            'message'=>'Application Session added successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainapplicationsession')->with($notification);
    }

    public function editApplicationSession($id)
    {
        $application_session = ApplicationSession::findOrFail($id);
        $semesters = Semester::all();
        return view('application_session.edit_application_session', compact('application_session', 'semesters'));
    }

    public function updateApplicationSession(Request $request, $id)
    {
        $request->validate([
            'application_semester' => 'required',
            'application_session_batch' => 'required',
            // 'semester_start_date' => 'required|date',
            // 'semester_end_date' => 'required|date|after_or_equal:semester_start_date',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'acceptance_start_date' => 'required|date',
            'acceptance_end_date' => 'required|date|after_or_equal:acceptance_start_date',
            'application_session_active' => 'required|in:0,1',
        ]);

        $now = now();
        $application_session = ApplicationSession::findOrFail($id);

        $currentStatus = $application_session->is_active ? '1' : '0';
        $newStatus = $request->application_session_active;

        // Check if application or acceptance dates were modified
        $datesChanged = (
            $application_session->application_start_date != $request->application_start_date ||
            $application_session->application_end_date != $request->application_end_date ||
            $application_session->acceptance_start_date != $request->acceptance_start_date ||
            $application_session->acceptance_end_date != $request->acceptance_end_date
        );

        // If status is changed but dates remain the same → reject
        if (!$datesChanged && $currentStatus !== $newStatus) {
            return back()->withErrors([
                'application_session_active' => 'To change the session status, you must also update the application or acceptance dates.',
            ])->withInput();
        }

        // Automatically adjust session status if only the dates were changed
        if ($datesChanged && $currentStatus === $newStatus) {
            if (Carbon::parse($request->acceptance_end_date)->gt($now)) {
                $newStatus = '1'; // Activate
            } else {
                $newStatus = '0'; // Deactivate
            }
        }

        // Validate status change logic
        if ($currentStatus === '1' && $newStatus === '0') {
            if (Carbon::parse($request->acceptance_end_date)->gt($now)) {
                return back()->withErrors([
                    'application_session_active' => 'To deactivate the session, the acceptance end date must not be later than the current date.',
                ])->withInput();
            }
        } elseif ($currentStatus === '0' && $newStatus === '1') {
            if (Carbon::parse($request->acceptance_end_date)->lte($now)) {
                return back()->withErrors([
                    'application_session_active' => 'To activate the session, the acceptance end date must be later than the current date.',
                ])->withInput();
            }
        }

        // Update session
        $semester = Semester::findOrFail($request->application_semester);

        $application_session->semester = $request->application_session_semester;
        $application_session->year = $request->application_session_year;
        $application_session->application_batch = $request->application_session_batch;
        $application_session->start_date = null;
        $application_session->end_date = null;
        $application_session->application_start_date = $request->application_start_date;
        $application_session->application_end_date = $request->application_end_date;
        $application_session->acceptance_start_date = $request->acceptance_start_date;
        $application_session->acceptance_end_date = $request->acceptance_end_date;
        $application_session->semester_id = $request->application_semester;
        $application_session->session_name = 'Application ' . $semester->name . ' Batch ' . intval($request->application_session_batch);
        $application_session->is_active = $newStatus == '1';

        $application_session->save();

        return redirect()->route('mainapplicationsession')->with([
            'message' => 'Application Session updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function deleteApplicationSession($id)
    {
        $application_session = ApplicationSession::findOrFail($id);
        $application_session->delete();

        $notification = array(
            'message'=>'Application Session deleted successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('mainapplicationsession')->with($notification);
    }
}
