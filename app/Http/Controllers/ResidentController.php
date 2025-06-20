<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Semester;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    public function indexResident()
    {
        $semesters = Semester::all();
        $residents = Resident::all();
        return view('resident.index_resident',compact('semesters','residents'));
    }
    
    public function mainResidentResident()
    {
        $user = auth()->user();

        if ($user->usertype !== 'resident') {
            return abort(403, 'Unauthorized');
        }

        $userResident = Resident::where('user_id', $user->id)->first();

        if (!$userResident) {
            return redirect()->back()->with(['error', 'Resident record not found.']);
        }

        $activeSemester = Semester::where('is_active', true)->first();

        if (!$activeSemester) {
            return redirect()->back()->with(['error', 'No active semester found.']);
        }

        if ($userResident->semester_id !== $activeSemester->id) {
            return redirect()->back()->with(['error', 'Your record is not part of the active semester.']);
        }

        // ✅ Get the house_name from the logged-in user's room
        $houseName = $userResident->room->house_name;

        // ✅ Fetch all residents assigned to rooms in the same house_name during the active semester
        $residents = Resident::where('semester_id', $activeSemester->id)
            ->whereHas('room', function ($query) use ($houseName) {
                $query->where('house_name', $houseName);
            })
            ->with('room')
            ->get();

            return view('resident.resident_by_house', compact('residents', 'userResident'));
        }

    public function mainResident($id)
    {
        $semester = Semester::findOrFail($id);
        $residents = Resident::where('semester_id', $id)->get();
        return view('resident.main_resident', compact('residents', 'semester'));
    }

    public function addResident($id)
    {
        $users = User::where('usertype', 'user')->get();
        $rooms = Room::where('status', 'available')->get();
        $semester = Semester::findOrFail($id);
        return view('resident.add_resident', compact('id', 'users', 'rooms', 'semester'));
    }

    public function showResident()
    {
        $userId = auth()->id();

        // Get the logged-in user's resident record
        $userResident = Resident::where('user_id', $userId)->first();

        if (!$userResident) {
            // Optionally handle if user has no resident record
            return redirect()->back()->with('error', 'Resident record not found.');
        }

        $houseName = $userResident->house_name;

        // Get all residents with the same house_name
        $residents = Resident::where('house_name', $houseName)->get();

        return view('resident.resident_by_house', compact('residents', 'userResident'));
    }

    public function storeResident(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $validated = $request->validate([
            'resident_user_id' => 'required',
            'resident_name' => 'required|string|max:255',
            'resident_user_id' => 'required|exists:users,id',
            'resident_email' => 'required|email',
            'resident_gender' => 'required|in:male,female',
            'resident_address' => 'required|string',
            'resident_room_id' => 'required|exists:rooms,id',
            // 'resident_semester_id' => 'required|exists:semesters,id',
            'resident_faculty' => 'nullable|string|max:255',
            'resident_program' => 'nullable|string|max:255',
            'resident_year_of_study' => 'nullable|string|max:255',
            'resident_contact_no' => 'required|string|max:20',
            'resident_check_in' => 'nullable|date',
            'resident_check_out' => 'nullable|date|after_or_equal:resident_check_in',
            'resident_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($request->resident_user_id);

        // Create new resident record
        // Assuming you have a Resident model and fillable properties set correctly
        $resident = new Resident();
        $resident->student_id = $user->user_id;
        $resident->name = $validated['resident_name'];
        $resident->user_id = $validated['resident_user_id'];
        $resident->email = $validated['resident_email'];
        // $resident->gender = $validated['resident_gender'];
        // $resident->address = $validated['resident_address'];
        $resident->room_id = $validated['resident_room_id'];
        $resident->semester_id = $request->resident_semester_id;
        $resident->faculty = $validated['resident_faculty'] ?? null;
        $resident->program = $validated['resident_program'] ?? null;
        $resident->year_of_study = $validated['resident_year_of_study'] ?? null;
        $resident->contact_no = $validated['resident_contact_no'] ?? null;
        $resident->check_in = $request->input('resident_check_in');
        $resident->check_out = $request->input('resident_check_out');

        if ($request->hasFile('resident_image')) {
            $imagePath = $request->file('resident_image');
            $path = $imagePath->store('residents','public');
            $resident->image = $path;
        }

        $resident->create_by_staff = true;
        $resident->created_by_id = auth()->user()->id;

        $resident->save();

        $room = Room::find($validated['resident_room_id']);
        if ($room) {
            $currentOccupy = (int) $room->occupy;
            $roomCapacity = (int) $room->capacity;

            if ($currentOccupy < $roomCapacity) {
                $room->occupy = $currentOccupy + 1;

                if ($room->occupy >= $roomCapacity) {
                    $room->status = 'full';
                }

                $room->save();
            }
        }

        // Get the category ID passed from the form
        $categoryId = $request->input('resident_category_id');

        $notification = [
            'message' => 'Resident created successfully!',
            'alert-type' => 'success',
        ];

        // Redirect to the route with the correct ID from addResident($id)
        return redirect()->route('mainresident', ['id' => $categoryId])->with($notification);

    }

    public function viewResident($id)
    {
        $resident = Resident::findOrFail($id);
        return view('resident.view_resident', compact('resident'));
    }

    public function editResident($residentId, $semesterId)
    {
        $users = User::where('usertype', 'user')->get();
        $rooms = Room::where('status', 'available')->get();
        $semester = Semester::findOrFail($semesterId); // explicitly use the passed semester
        $resident = Resident::findOrFail($residentId);

        return view('resident.edit_resident', compact('users', 'rooms', 'semester', 'resident'));
    }

    public function updateResident(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            // 'resident_user_id' => 'required|exists:users,id',
            'resident_name' => 'required|string|max:255',
            'resident_email' => 'required|email',
            // 'resident_gender' => 'required|in:male,female',
            // 'resident_address' => 'required|string',
            'resident_room_id' => 'required|exists:rooms,id',
            // 'resident_semester_id' => 'required|exists:semesters,id',
            'resident_faculty' => 'nullable|string|max:255',
            'resident_program' => 'nullable|string|max:255',
            'resident_year_of_study' => 'nullable|string|max:255',
            'resident_contact_no' => '|string|max:20',
            'resident_check_in' => 'nullable|date',
            'resident_check_out' => 'nullable|date|after_or_equal:resident_check_in',
            'resident_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the resident by ID
        $resident = Resident::findOrFail($id);
        // $user = User::findOrFail($request->resident_user_id);

        // Update resident data
        // $resident->student_id = $user->user_id;
        // $resident->name = $validated['resident_name'];
        // $resident->user_id = $validated['resident_user_id'];
        // $resident->email = $validated['resident_email'];
        // $resident->gender = $validated['resident_gender'];
        // $resident->address = $validated['resident_address'];
        $resident->room_id = $validated['resident_room_id'];
        // $resident->semester_id = $validated['resident_semester_id'];
        $resident->faculty = $validated['resident_faculty'] ?? null;
        $resident->program = $validated['resident_program'] ?? null;
        $resident->year_of_study = $validated['resident_year_of_study'] ?? null;
        $resident->contact_no = $validated['resident_contact_no'] ?? null;
        $resident->check_in = $request->input('resident_check_in');
        $resident->check_out = $request->input('resident_check_out');

        if ($request->hasFile('resident_image')) {
            // Optional: delete old image from storage
            if ($resident->image && Storage::disk('public')->exists($resident->image)) {
                Storage::disk('public')->delete($resident->image);
            }

            $imagePath = $request->file('resident_image');
            $path = $imagePath->store('residents', 'public');
            $resident->image = $path;
        }

        // $resident->updated_by_id = auth()->user()->id; // optional tracking
        $resident->save();

        $room = Room::find($validated['resident_room_id']);
        if ($room) {
            $currentOccupy = (int) $room->occupy;
            $roomCapacity = (int) $room->capacity;

            if ($currentOccupy < $roomCapacity) {
                $room->occupy = $currentOccupy + 1;

                if ($room->occupy >= $roomCapacity) {
                    $room->status = 'unavailable';
                }

                $room->save();
            }
        }

        $categoryId = $request->input('resident_semester_id');

        $notification = [
            'message' => 'Resident updated successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('mainresident', ['id' => $categoryId])->with($notification);
    }

    public function showCheckIn($id)
    {
        $resident = Resident::findOrFail($id);
        return view('resident.show_check', compact('resident'));
    }

    public function showCheckOut($id)
    {
        $resident = Resident::findOrFail($id);
        return view('resident.show_check', compact('resident'));
    }

    public function residentCheckIn(Request $request, $id)
    {
        $request->validate([
            'resident_check_in' => 'required|date',
        ]);

        $userResident = Resident::findOrFail($id);
        $userResident->check_in = $request->resident_check_in;

        $userResident->save();

        $notification = array(
            'message'=>'Check in successfully.',
            'alert-type'=>'success',
        );

        return redirect()->route('mainresidentresident')->with($notification);
    }

    public function residentCheckOut(Request $request, $id)
    {
        $request->validate([
            'resident_check_out' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($id) {
                    $resident = \App\Models\Resident::find($id);
                    if ($resident && $resident->check_in && $value < $resident->check_in) {
                        $fail('The check-out date must be after or equal to the check-in date.');
                    }
                },
            ],
        ]);

        $userResident = Resident::findOrFail($id);
        $userResident->check_out = $request->resident_check_out;

        $userResident->save();

        if ($userResident->room_id) {
            $room = Room::find($userResident->room_id);

            if ($room) {
                // Convert string to integer before subtracting
                $occupyCount = (int) $room->occupy;
                $newOccupy = max(0, $occupyCount - 1); // prevent negative numbers

                $room->occupy = (string) $newOccupy; // cast back to string if needed

                // If room is now empty, mark it as available
                if ($newOccupy === 0) {
                    $room->status = 'available';
                }

                $room->save();
            }
        }

        $notification = array(
            'message'=>'Check out successfully.',
            'alert-type'=>'success',
        );

        return redirect()->route('mainresidentresident')->with($notification);
    }

    public function deleteResident($id)
    {
        $complaint = Resident::findOrFail($id);
        $complaint->delete();

        $notification = array(
            'message'=>'Complaint deleted successfully',
            'alert-type'=>'info',
        );
        return redirect()->back()->with($notification);
    }
}
