<?php

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AbilityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationSessionController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VisitationController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\Complaint;
use App\Models\Resident;
use App\Models\Semester;
use App\Models\Visitation;
use App\Models\Room;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Jobs\RunRoomAllocationGA;
use App\Models\AllocationStatus;
use Illuminate\Support\Facades\Log;
use Silber\Bouncer\BouncerFacade as Bouncer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/notifications/clear', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.clear');

Route::get('/notifications/read/{id}', function ($id) {
    $notification = auth()->user()->notifications->where('id', $id)->first();

    if ($notification) {
        $notification->markAsRead();
        $url = $notification->data['url'] ?? url('/');
        return redirect($url);
    }

    return redirect()->back();
})->name('notifications.read');

Route::get('/notifications', function () {
    $daysLimit = 7;
    $maxNotifications = 100;

    $notifications = Auth::user()
        ->notifications
        ->where('created_at', '>=', now()->subDays($daysLimit))
        ->sortByDesc('created_at')
        ->take($maxNotifications);

    return view('notification', compact('notifications', 'daysLimit'));
})->name('notifications.index');


Route::get('/dashboard', function () {
    
    $user = auth()->user();

    $resident = Resident::where('user_id', $user->id)->first();

    // Default null/zero values for all variables
    $announcementCount = 0;
    $applicationCount = 0;
    $complaintCount = 0;
    $residentCount = 0;
    $visitationCount = 0;
    $availableRoomCount = 0;
    $announcements = Announcement::where('status', 'published')->latest()->take(3)->get();

    if($user->usertype == 'superadmin' || $user->usertype === 'staff') {
        // Get active semester
        $activeSemester = Semester::where('is_active', true)->first();
        // Announcements: latest 3 with status 'published'
        $announcementCount = Announcement::where('status', 'published')->latest()->take(3)->count();
        $announcements = Announcement::where('status', 'published')->latest()->take(3)->get();
        // Applications: where session's semester is active
        $applicationCount = Application::whereHas('session.semester', function ($query) {
            $query->where('is_active', true);
        })->count();
        // Complaints: pending
        $complaintCount = Complaint::where('status', 'pending')->count();
        // Residents: where semester is active
        $residentCount = Resident::whereHas('semester', function ($query) {
            $query->where('is_active', true);
        })->count();
        // Visitations: today
        $visitationCount = Visitation::whereDate('created_at', Carbon::today())->count();
        // Available rooms
        $availableRoomCount = Room::where('status', 'available')->count(); // Adjust 'status' if your schema differs
    }

    return view('admin.index', compact(
        'announcementCount',
        'applicationCount',
        'complaintCount',
        'residentCount',
        'visitationCount',
        'availableRoomCount',
        'announcements',
        'resident'
    ));
})->middleware(['auth', 'verified', 'mustChangePassword'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/view', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/password/change', [UserController::class, 'changeFirstPassword'])->name('first.password.change');
    Route::post('/password/update', [UserController::class, 'updateFirstPassword'])->name('first.password.update');

    Route::get('/logout', function () {
        Auth::logout();  // Log out the user
        return redirect('/');  // Redirect to the home page or any page you prefer
    })->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/edit-password/change', [PasswordController::class, 'edit'])->name('changepasswordedit');
    Route::post('/update-password/change', [PasswordController::class, 'update'])->name('changepasswordupdate');
});

Route::controller(FacilityController::class)->group(function(){
    Route::get('/main/facilityasset','mainFacility')->name('mainfacility');
    Route::get('/add/facilityasset', 'addFacility')->name('addfacility');
    Route::post('/store/facilityasset', 'storeFacility')->name('storefacility');
    Route::get('/edit/{id}/facilityasset', 'editFacility')->name('editfacility');
    Route::post('/update/{id}/facilityasset','updateFacility')->name('updatefacility');
    Route::get('/delete/{id}/facilityasset', 'deleteFacility')->name('deletefacility');
});

Route::controller(FacilityTypeController::class)->group(function(){
    Route::get('/main/facilitytype','mainFacilityType')->name('mainfacilitytype');
    Route::get('/add/facilitytype', 'addFacilityType')->name('addfacilitytype');
    Route::post('/store/facilitytype', 'storeFacilityType')->name('storefacilitytype');
    Route::get('/edit/{id}/facilitytype', 'editFacilityType')->name('editfacilitytype');
    Route::post('/update/{id}/facilitytype','updateFacilityType')->name('updatefacilitytype');
    Route::get('/delete/{id}/facilitytype', 'deleteFacilityType')->name('deletefacilitytype');
});

Route::controller(RoomController::class)->group(function(){
    Route::get('/main/room','mainRoom')->name('mainroom');
    Route::get('/add/room','addRoom')->name('addroom');
    Route::post('/store/room','storeRoom')->name('storeroom');
    Route::get('/edit/{id}/room','editRoom')->name('editroom');
    Route::post('/update/{id}/room','updateRoom')->name('updateroom');
    Route::get('/delete/{id}/room','deleteRoom')->name('deleteroom');
});

Route::controller(AnnouncementController::class)->group(function () {
    Route::get('/main/announcement', 'mainAnnouncement')->name('mainannouncement');
    Route::get('/add/announcement', 'addAnnouncement')->name('addannouncement');
    Route::post('/store/announcement', 'storeAnnouncement')->name('storeannouncement');
    Route::get('/edit/{id}/announcement', 'editAnnouncement')->name('editannouncement'); // Pass ID for editing
    Route::post('/update/{id}/announcement', 'updateAnnouncement')->name('updateannouncement'); // Pass ID for updating  
    Route::get('/delete/{id}/announcement', 'deleteAnnouncement')->name('deleteannouncement'); // Use DELETE
    Route::get('/draft/announcement', 'draftAnnouncement')->name('draftannouncement');
    Route::get('/archieve/announcement', 'archiveAnnouncement')->name('archiveannouncement');
    Route::post('/update-archive/announcement', 'updateStatus')->name('updatestatus'); // For AJAX status update
});

Route::prefix('admin')->group(function(){
    Route::resource('roles', RoleController::class)->names('adminroles');
    Route::post('abilities', [AbilityController::class, 'store'])->name('adminabilitiesstore');
});

Route::controller(UserController::class)->group(function(){
    Route::get('/main/user','mainUser')->name('mainuser');
    Route::get('/add/user','addUser')->name('adduser');
    Route::post('/store/user','storeUser')->name('storeuser');
    Route::get('/edit/{id}/user','editUser')->name('edituser');
    Route::post('/update/{id}/user','updateUser')->name('updateuser');
    Route::get('/delete/{id}/user','deleteUser')->name('deleteuser');
});

Route::controller(ApplicationSessionController::class)->group(function(){
    Route::get('/main/session/application','mainApplicationSession')->name('mainapplicationsession');
    Route::get('/add/session/application','addApplicationSession')->name('addapplicationsession');
    Route::post('/store/session/application','storeApplicationSession')->name('storeapplicationsession');
    // Route::get('/applicationsession/viewapplicationsession/{id}','viewApplicationSession')->name('viewapplicationsession');
    Route::get('/edit/{id}/session/application','editApplicationSession')->name('editapplicationsession');
    Route::post('/update/{id}/session/application','updateApplicationSession')->name('updateapplicationsession');
    Route::get('/delete/{id}/session/application','deleteApplicationSession')->name('deleteapplicationsession');
});

Route::middleware('auth')->controller(ApplicationController::class)->group(function(){
    Route::get('/index/application','indexApplication')->name('indexapplication');
    Route::get('/main/{id}/application','mainApplication')->name('mainapplication');
    Route::get('/main/residentapplication','mainResidentApplication')->name('mainresidentapplication');
    Route::get('/add/{id}/application','addApplication')->name('addapplication');
    Route::get('/view/{id}/application','viewApplication')->name('viewapplication');
    Route::post('/store/application','storeApplication')->name('storeapplication');
    Route::post('/update/applicationstatus/{id}/application','updateApplicationStatus')->name('updateapplicationstatus');
    Route::post('/update/acceptancestatus/{id}/application','updateAcceptanceStatus')->name('updateacceptancestatus');
    Route::get('/delete/{id}/application','deleteApplication')->name('deleteapplication');
    Route::get('/download/{id}/form-application','downloadApplicationPDF')->name('downloadapplicationpdf');
    // Route::get('/allocateroom/application', 'runRoomAllocationGA')->name('runroomallocation');
    Route::get('view/{id}/roomallocation/application','roomAllocation')->name('roomallocation');
    Route::get('/view/roomallocation/batch/{session_id}/{chunk_index}/application', 'roomAllocationBatch')->name('roomallocationbatch');
});

Route::controller(VisitationController::class)->group(function() {
    Route::get('/index/visitation', 'mainVisitation')->name('mainvisitation');
    Route::get('/add/visitation', 'addVisitation')->name('addvisitation');
    Route::post('/store/visitation', 'storeVisitation')->name('storevisitation');
    Route::get('/view/{id}/visitation', 'viewVisitation')->name('viewvisitation');
    Route::get('/edit/{id}/visitation', 'editVisitation')->name('editvisitation');
    Route::post('/update/{id}/visitation', 'updateVisitation')->name('updatevisitation');
    Route::get('/viewqrcode/visitation', 'viewTokenQr')->name('viewvisitationqr');
    Route::get('/show/public-form/visitation', 'publicForm')->name('visitationpublicform');
    Route::post('/store/public-form/visitation', 'storePublicVisitation')->name('storevisitationpublicform');
    Route::get('/download-qr/visitation', 'downloadQr')->name('downloadqr');
    Route::match(['get', 'post'], '/check-contact/visitation', 'checkContact')->name('visitation.checkContact');
    Route::get('/form/visitation', 'scanQr')->name('visitation.form');
    Route::get('/delete/{id}/visitation', 'deleteVisitation')->name('deletevisitation');
});

Route::controller(ComplaintController::class)->group(function(){
    Route::get('/index/complaint', 'indexComplaint')->name('indexcomplaint');
    Route::get('/main/complaint','mainComplaint')->name('maincomplaint');
    Route::get('/add/complaint', 'addComplaint')->name('addcomplaint');
    Route::post('/store/complaint', 'storeComplaint')->name('storecomplaint');
    Route::get('/view/{id}/complaint', 'viewComplaint')->name('viewcomplaint');
    Route::get('/edit/{id}/complaint', 'editComplaint')->name('editcomplaint');
    Route::post('/response/{id}/complaint', 'responseComplaint')->name('responsecomplaint');
    Route::post('/update/{id}/complaint','updateComplaintFeedback')->name('updatecomplaintfeedback');
    Route::post('/receivecomplaint/{id}/complaint', 'receiveComplaint')->name('receivecomplaint');
    Route::post('/completecomplaint/{id}/complaint', 'completeComplaint')->name('completecomplaint');
    Route::get('/download/{id}/form-complaint', 'downloadComplaintPDF')->name('downloadcomplaintform');
    Route::get('/delete/{id}/complaint', 'deleteComplaint')->name('deletecomplaint');
}); 

Route::middleware('auth')->controller(ResidentController::class)->group(function () {
    Route::get('/index/userresident', 'indexResident')->name('indexresident');
    Route::get('/main/userstudentresident', 'mainResidentResident')->name('mainresidentresident');
    Route::get('/main/{id}/userresident', 'mainResident')->name('mainresident');
    Route::get('/show/check-in/{id}/userresident', 'showCheckIn')->name('showcheckin');
    Route::get('/show/check-out/{id}/userresident', 'showCheckOut')->name('showcheckout');
    Route::post('/update/check-in/{id}/userresident', 'residentCheckIn')->name('residentcheckin');
    Route::post('/update/check-out/{id}/userresident', 'residentCheckOut')->name('residentcheckout');

    // Protect creation and storing with admin only
    Route::middleware('admin')->group(function () {
        Route::get('/add/{id}/resident', 'addResident')->name('addresident');
        Route::post('/store/resident', 'storeResident')->name('storeresident');
        Route::get('/view/{id}/resident', 'viewresident')->name('viewresident');
        Route::get('/edit/{resident}/{semester}/resident', 'editResident')->name('editresident');
        Route::post('/update/{id}/resident', 'updateResident')->name('updateresident');
        Route::get('/delete/{id}/resident', 'deleteResident')->name('deleteresident');
    });
});


Route::controller(SemesterController::class)->group(function () {
    Route::get('/main/semester', 'mainSemester')->name('mainsemester');
    Route::get('/add/semester', 'addSemester')->name('addsemester');
    Route::post('/store/semester', 'storeSemester')->name('storesemester'); 
    Route::get('/view/{id}/semester', 'viewSemester')->name('viewsemester');
    Route::get('/edit/{id}/semester', 'editSemester')->name('editsemester');
    Route::post('/update/{id}/semester', 'updateSemester')->name('updatesemester');
    Route::get('/view/{id}/semester', 'viewSemester')->name('viewsemester');
    Route::get('/delete/{id}/semester', 'deleteSemester')->name('deletesemester');
});

// Run Room Allocation
Route::post('/run-room-allocation', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'session_id' => 'required|integer|exists:application_sessions,id',
        'chunk_number' => 'required|integer|min:1', // ✅ validate chunk number
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $sessionId = $request->input('session_id');
    $chunkNumber = $request->input('chunk_number');

    Log::info("📦 Dispatching job with session ID {$sessionId} and chunk number: {$chunkNumber}");

    // ✅ Get or create status record for this session + chunk
    $status = AllocationStatus::firstOrNew([
        'session_id' => $sessionId,
        'chunk_number' => $chunkNumber,
    ]);

    if ($status->is_running) {
        return redirect()->back()->with('match_percentage', 'Room allocation is already running for this chunk. Please wait...');
    }

    try {
        $status->chunk_number = $chunkNumber; // ✅ explicitly set it
        $status->is_running = true;
        $status->is_confirmed = false;
        $status->save();

        // ✅ Dispatch with chunk number
        dispatch(new RunRoomAllocationGA($sessionId, $chunkNumber, auth()->user()))
            ->onQueue('room-allocation')
            ->delay(now()->addSeconds(5)); // Optional: delay the job by 5 seconds

        return redirect()->back()->with('match_percentage', 'Room allocation job has been queued.');
    } catch (\Throwable $e) {
        Log::error("Failed to dispatch room allocation job for session {$sessionId}, chunk {$chunkNumber}: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('match_percentage', 'An error occurred while queuing the job.');
    }
})->name('runRoomAllocation');


// Confirm Room Allocation

Route::post('/confirm-allocation', function (Request $request) {
    $sessionId = $request->input('session_id');
    $chunkNumber = $request->input('chunk_number'); // ✅

    $status = AllocationStatus::where('session_id', $sessionId)
                              ->where('chunk_number', $chunkNumber)
                              ->firstOrFail();

    $status->is_confirmed = true;
    $status->is_running = false;
    $status->save();

    return redirect()->back()->with('message', "Chunk {$chunkNumber} confirmed successfully.");
})->name('confirmallocation');



// Terminate Room Allocation
Route::post('/terminate-room-allocation', function (Request $request) {
    $sessionId = $request->input('session_id');
    $chunkNumber = $request->input('chunk_number');

    DB::table('allocation_statuses')
        ->where('session_id', $sessionId)
        ->where('chunk_number', $chunkNumber)
        ->update(['is_running' => false]);

    return redirect()->back()->with('message', "Allocation for chunk {$chunkNumber} has been terminated.");
})->name('terminate-allocation');

require __DIR__.'/auth.php';
