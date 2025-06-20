<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function mainSemester()
    {
        $semesters = Semester::all();
        return view('semester.main_semester', compact('semesters'));
    }

    public function addSemester()
    {
        return view('semester.add_semester');
    }

    public function storeSemester(Request $request)
    {
        $request->validate([
            'semester_sem' => 'required',
            'semester_year' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Match format using regex inside the closure
                    if (!preg_match('/^\d{4}\/\d{4}$/', $value)) {
                        return $fail('The ' . str_replace('_', ' ', $attribute) . ' must be in the format YYYY/YYYY.');
                    }

                    [$start, $end] = explode('/', $value);

                    if ((int)$end !== (int)$start + 1) {
                        return $fail('The ' . str_replace('_', ' ', $attribute) . ' must contain two consecutive years, like 2023/2024.');
                    }
                }
            ],


            'sem_start_date' => 'required|date',
            'sem_end_date' => 'required|date|after_or_equal:sem_start_date',
            'activation_start_date' => 'required|date',
            'activation_end_date' => 'required|date|after_or_equal:activation_start_date',
        ]);

        $semester = new Semester();
        $semester->name = 'Sem ' . $request->semester_sem . ' ' . $request->semester_year;
        $semester->semester_sem = $request->semester_sem;
        $semester->semester_year = $request->semester_year;
        $semester->start_date = $request->sem_start_date;
        $semester->end_date = $request->sem_end_date;
        $semester->activated_at = $request->activation_start_date; 
        $semester->deactivated_at = $request->activation_end_date; 
        $now = now();
        if ($now->between($semester->activated_at, $semester->deactivated_at)) {
            $semester->is_active = true;
        } else {
            $semester->is_active = false;
        }
        
        $semester->save();

        $notification = array(
            'message' => 'Semester added successfully.',
            'alert-type' => 'success'   
        );

        return redirect()->route('mainsemester')->with($notification);
    }

    public function editSemester($id)
    {
        $semester = Semester::findOrFail($id);
        return view('semester.edit_semester', compact('semester'));
    }

    public function updateSemester(Request $request, $id)
    {
        $request->validate([
            'semester_sem' => 'required',
            'semester_year' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Match format using regex inside the closure
                    if (!preg_match('/^\d{4}\/\d{4}$/', $value)) {
                        return $fail('The ' . str_replace('_', ' ', $attribute) . ' must be in the format YYYY/YYYY.');
                    }

                    [$start, $end] = explode('/', $value);

                    if ((int)$end !== (int)$start + 1) {
                        return $fail('The ' . str_replace('_', ' ', $attribute) . ' must contain two consecutive years, like 2023/2024.');
                    }
                }
            ],


            'sem_start_date' => 'required|date',
            'sem_end_date' => 'required|date|after_or_equal:sem_start_date',
            'activation_start_date' => 'required|date',
            'activation_end_date' => 'required|date|after_or_equal:activation_start_date',
        ]);

        $semester = Semester::findOrFail($id);
        $semester->name = 'Sem ' . $request->semester_sem . ' ' . $request->semester_year;
        $semester->semester_sem = $request->semester_sem;
        $semester->semester_year = $request->semester_year;
        $semester->start_date = $request->sem_start_date;
        $semester->end_date = $request->sem_end_date;
        $semester->activated_at = $request->activation_start_date; 
        $semester->deactivated_at = $request->activation_end_date; 
        $now = now();
        if ($now->between($request->activation_start_date, $request->activation_end_date)) {
            $semester->is_active = true;
        } else {
            $semester->is_active = false;
        }
        $semester->save();

        $notification = array(
            'message' => 'Semester updated successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('mainsemester')->with($notification);
    }

    public function viewSemester($id)
    {
        $semester = Semester::findOrFail($id);
        return view('semester.view_semester', compact('semester'));
    }

    public function deleteSemester($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();

        $notification = array(
            'message' => 'Semester deleted successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('mainsemester')->with($notification);
    }
}
