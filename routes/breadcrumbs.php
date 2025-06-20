<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

use function Symfony\Component\String\b;

//Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

//Dashboard > Application Session
Breadcrumbs::for('application_session', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Application Session', route('mainapplicationsession'));
});

//Dashboard > Application Session > Add Application Session
Breadcrumbs::for('add_application_session', function (BreadcrumbTrail $trail) {
    $trail->parent('application_session');
    $trail->push('Add Application Session', route('addapplicationsession'));
});

//Dashboard > Application Session > Edit Application Session
Breadcrumbs::for('edit_application_session', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('application_session');
    $trail->push('Edit Application Session', route('editapplicationsession', ['id'=>$id]));
});

//Dashboard > Application Seesion > Application
Breadcrumbs::for('application', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('application_session');
    $trail->push('Application', route('mainapplication', ['id' => $id]));
});

//Dashboard > Application Session > Application > Application Details
Breadcrumbs::for('application_details', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('application', $id);
    $trail->push('Application Details', route('viewapplication', ['id' => $id]));
});

//Dashboard > Facility
Breadcrumbs::for('facility', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Facility', route('mainfacility'));
});

//Dashboard > Facility > Add Facility
Breadcrumbs::for('add_facility', function (BreadcrumbTrail $trail) {
    $trail->parent('facility');
    $trail->push('Add Facility', route('addfacility'));
});

//Dashboard > Facility > Edit Facility
Breadcrumbs::for('edit_facility', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('facility');
    $trail->push('Edit Facility', route('editfacility', ['id' => $id]));
});

//Dashboard > Facility Type
Breadcrumbs::for('facility_type', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Facility Type', route('mainfacilitytype'));
});

//Dashboard > Facility Type > Add Facility Type
Breadcrumbs::for('add_facility_type', function (BreadcrumbTrail $trail) {
    $trail->parent('facility_type');
    $trail->push('Add Facility Type', route('addfacilitytype'));
});

//Dashboard > Facility Type > Edit Facility Type
Breadcrumbs::for('edit_facility_type', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('facility_type');
    $trail->push('Edit Facility Type', route('editfacilitytype', ['id' => $id]));
});

//Dashboard > Announcement 
Breadcrumbs::for('announcement', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Announcement', route('mainannouncement'));
});

//Dashboard > Announcement > Draft Announcement
Breadcrumbs::for('draft_announcement', function (BreadcrumbTrail $trail) {
    $trail->parent('announcement');
    $trail->push('Draft Announcement', route('draftannouncement'));
});

//Dashboard > Announcement > Archive Announcement
Breadcrumbs::for('archive_announcement', function (BreadcrumbTrail $trail) {
    $trail->parent('announcement');
    $trail->push('Archive Announcement', route('archiveannouncement'));
});

//Dashboard > Announcement > Add Announcement
Breadcrumbs::for('add_announcement', function (BreadcrumbTrail $trail) {
    $trail->parent('announcement');
    $trail->push('Add Announcement', route('addannouncement'));
});

//Dashboard > Announcement > Edit Announcement
Breadcrumbs::for('edit_announcement', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('announcement');
    $trail->push('Edit Announcement', route('editannouncement', ['id' => $id]));
});

//Dashboard > Complaint 
Breadcrumbs::for('index_complaint', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Complaint', route('indexcomplaint'));
});

//Dashboard > Complaint > Add Complaint
Breadcrumbs::for('add_complaint', function (BreadcrumbTrail $trail) {
    $trail->parent('index_complaint');
    $trail->push('Add Complaint', route('addcomplaint'));
});

//Dashboard > Complaint > Response Complaint
Breadcrumbs::for('response_complaint', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('index_complaint');
    $trail->push('Response Complaint', route('responsecomplaint', ['id' => $id]));
});

//Dashboard > Complaint > Pending Complaint
Breadcrumbs::for('pending_complaint', function (BreadcrumbTrail $trail) {
    $trail->parent('index_complaint');
    $trail->push('Pending Complaint', route('maincomplaint', ['status' => 'pending']));
});

//Dashboard > Complaint > In Progress Complaint
Breadcrumbs::for('in_progress_complaint', function (BreadcrumbTrail $trail) {
    $trail->parent('index_complaint');
    $trail->push('In Progress Complaint', route('maincomplaint', ['status' => 'in_progress']));
});

//Dashboard > Complaint > Complete Complaint
Breadcrumbs::for('completed_complaint', function (BreadcrumbTrail $trail) {
    $trail->parent('index_complaint');
    $trail->push('Completed Complaint', route('maincomplaint', ['status' => 'completed']));
});

//Dashboard > User
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('mainuser'));
}); 

//Dashboard > User > Add User
Breadcrumbs::for('add_user', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Add User', route('adduser'));
});

//Dashboard > User > Edit User
Breadcrumbs::for('edit_user', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('user');
    $trail->push('Edit User', route('edituser', ['id' => $id]));
});

//Dashboard > User > Role
Breadcrumbs::for('main_role', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('adminroles.index'));
});

//Dashboard > User > Create Role
Breadcrumbs::for('create_role', function (BreadcrumbTrail $trail) {
    $trail->parent('main_role');
    $trail->push('Create Role', route('adminroles.create'));
});

//Dashboard > User > User Access
Breadcrumbs::for('edit_user_access', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_role');
    $trail->push('User Access', route('adminroles.edit',['role' => $id]));
});

//Dashboard > Room
Breadcrumbs::for('room', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Room', route('mainroom'));
});

//Dashboard > Room > Add Room
Breadcrumbs::for('add_room', function (BreadcrumbTrail $trail) {
    $trail->parent('room');
    $trail->push('Add Room', route('addroom'));
});

//Dashboard > Room > Edit Room
Breadcrumbs::for('edit_room', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('room');
    $trail->push('Edit Room', route('editroom', ['id' => $id]));
});

//Dashbord > Application
Breadcrumbs::for('main_application', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Application', route('mainresidentapplication'));
});

//Dashboard > Semester
Breadcrumbs::for('main_semester', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Semester', route('mainsemester'));
});

//Dashboard >  Semester > Add Semester
Breadcrumbs::for('add_semester', function (BreadcrumbTrail $trail) {
    $trail->parent('main_semester');
    $trail->push('Add Semester', route('addsemester'));
});

//Dashboard >  Semester > View Semester
Breadcrumbs::for('view_semester', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_semester');
    $trail->push('View Semester', route('viewsemester', ['id' => $id]));
});

//Dashboard >  Semester > Edit Semester
Breadcrumbs::for('edit_semester', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_semester');
    $trail->push('Edit Semester', route('editsemester', ['id' => $id]));
});

//Dashboard > Visitation 
Breadcrumbs::for('main_visitation', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Visitation', route('mainvisitation'));
});

//Dashboard > Visitation > Add Visitation
Breadcrumbs::for('add_visitation', function (BreadcrumbTrail $trail) {
    $trail->parent('main_visitation');
    $trail->push('Add Visitation', route('addvisitation'));
});

//Dashboard > Visitation > Edit Visitation
Breadcrumbs::for('edit_visitation', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_visitation');
    $trail->push('Edit Visitation', route('editvisitation', ['id' => $id]));
});

//Dashboard > Visitation > View Visitation
Breadcrumbs::for('view_visitation', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_visitation');
    $trail->push('View Visitation', route('viewvisitation', ['id' => $id]));
});

//Dashboard > Visitation > View Visitation QR
Breadcrumbs::for('view_visitation_qr', function (BreadcrumbTrail $trail) {
    $trail->parent('main_visitation');
    $trail->push('View Visitation QR', route('viewvisitationqr', ['token' => 'dummy-token']));
});

//Dashboard > Index Resident 
Breadcrumbs::for('index_resident', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Semester Resisent', route('indexresident'));
});

//Dashboard > Index Resident > Main Resident 
Breadcrumbs::for('main_resident', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('index_resident');
    $trail->push('Resident', route('mainresident', ['id' => $id]));
});

//Dachboard > Index Resident > Resident Details
Breadcrumbs::for('view_resident', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_resident', $id);
    $trail->push('Resident Detail', route('viewresident', ['id' => $id]));
});

//Dachboard > Index Resident > Edit Resident
Breadcrumbs::for('edit_resident', function (BreadcrumbTrail $trail, $semester_id, $resident_id) {
    $trail->parent('main_resident', $semester_id);
    $trail->push('Edit Resident', route('editresident', ['resident' => $resident_id, 'semester' => $semester_id]));
});

//Dachboard > Resident Details
Breadcrumbs::for('main_housemate_resident', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Resident Details', route('mainresidentresident'));
});

//Dachboard > Resident Details > Check In
Breadcrumbs::for('resident_check_in', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_housemate_resident');
    $trail->push('Resident Check In', route('residentcheckin', ['id' => $id]));
});

//Dachboard > Resident Details > Check Out
Breadcrumbs::for('resident_check_out', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('main_housemate_resident');
    $trail->push('Resident Check Out', route('residentcheckout', ['id' => $id]));
});

//Dachboard > Room Allocation
Breadcrumbs::for('room_allocation', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('application', $id);
    $trail->push('Room Allocation', route('roomallocation', ['id' => $id]));
});

//Dachboard > Room Allocation > Batch
Breadcrumbs::for('room_allocation_batch', function (BreadcrumbTrail $trail, $sessionId, $chunkIndex) {
    $trail->parent('room_allocation', $sessionId);
    $trail->push("Batch {$chunkIndex}", route('roomallocationbatch', [
        'session_id' => $sessionId,
        'chunk_index' => $chunkIndex
    ]));
});
