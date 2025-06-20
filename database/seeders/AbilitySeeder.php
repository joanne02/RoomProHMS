<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Ability;

class AbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ability::create(['name'=>'create_facility', 'title' => 'Create Facility']);
        Ability::create(['name'=>'read_facility', 'title' => 'Read Facility']);
        Ability::create(['name'=>'update_facility', 'title' => 'Update Facility']);
        Ability::create(['name'=>'delete_facility', 'title' => 'Delete Facility']);

        Ability::create(['name'=>'create_facility_type', 'title' => 'Create Facility Type']);
        Ability::create(['name'=>'read_facility_type', 'title' => 'Read Facility Type']);
        Ability::create(['name'=>'update_facility_type', 'title' => 'Update Facility Type']);
        Ability::create(['name'=>'delete_facility_type', 'title' => 'Delete Facility Type']);

        Ability::create(['name'=>'create_room', 'title' => 'Create Room']);
        Ability::create(['name'=>'read_room', 'title' => 'Read Room']);
        Ability::create(['name'=>'update_room', 'title' => 'Update Room']);
        Ability::create(['name'=>'delete_room', 'title' => 'Delete Room']);

        Ability::create(['name'=>'create_announcement', 'title' => 'Create Announcement']);
        Ability::create(['name'=>'read_announcement', 'title' => 'Read Announcement']);
        Ability::create(['name'=>'update_announcement', 'title' => 'Update Announcement']);
        Ability::create(['name'=>'delete_announcement', 'title' => 'Delete Announcement']);

        Ability::create(['name'=>'create_application', 'title' => 'Create Application']);
        Ability::create(['name'=>'read_application', 'title' => 'Read Application']);
        Ability::create(['name'=>'update_application', 'title' => 'Update Application']);
        Ability::create(['name'=>'delete_application', 'title' => 'Delete Application']);
        
        Ability::create(['name'=>'approve_application', 'title' => 'Approve Application']);
        Ability::create(['name'=>'accept_application', 'title' => 'Accept Application']);

        Ability::create(['name'=>'create_application_session', 'title' => 'Create Application Session']);
        Ability::create(['name'=>'read_application_session', 'title' => 'Read Application Session']);
        Ability::create(['name'=>'update_application_session', 'title' => 'Update Application Session']);
        Ability::create(['name'=>'delete_application_session', 'title' => 'Delete Application Session']);

        Ability::create(['name'=>'create_visitation', 'title' => 'Create Visitation']);
        Ability::create(['name'=>'read_visitation', 'title' => 'Read Visitation']);
        Ability::create(['name'=>'update_visitation', 'title' => 'Update Visitation']);
        Ability::create(['name'=>'delete_visitation', 'title' => 'Delete Visitation']);
        
        Ability::create(['name'=>'create_complaint', 'title' => 'Create Complaint']);
        Ability::create(['name'=>'read_complaint', 'title' => 'Read Complaint']);
        Ability::create(['name'=>'update_complaint', 'title' => 'Update Complaint']);
        Ability::create(['name'=>'delete_complaint', 'title' => 'Delete Complaint']);

        Ability::create(['name'=>'create_resident', 'title' => 'Create Resident']);
        Ability::create(['name'=>'read_resident', 'title' => 'Read Resident']);
        Ability::create(['name'=>'update_resident', 'title' => 'Update Resident']);
        Ability::create(['name'=>'delete_resident', 'title' => 'Delete Resident']);

        Ability::create(['name'=>'create_role', 'title' => 'Create Role']);
        Ability::create(['name'=>'read_role', 'title' => 'Read Role']);
        Ability::create(['name'=>'update_role', 'title' => 'Update Role']);
        Ability::create(['name'=>'delete_role', 'title' => 'Delete Role']);

        Ability::create(['name'=>'create_user', 'title' => 'Create User']);
        Ability::create(['name'=>'read_user', 'title' => 'Read User']);
        Ability::create(['name'=>'update_user', 'title' => 'Update User']);
        Ability::create(['name'=>'delete_user', 'title' => 'Delete User']);

        Ability::create(['name'=>'create_user_access', 'title' => 'Create User Access']);
        Ability::create(['name'=>'read_user_access', 'title' => 'Read User Access']);
        Ability::create(['name'=>'update_user_access', 'title' => 'Update User Access']);
        Ability::create(['name'=>'delete_user_access', 'title' => 'Delete User Access']);

        Ability::create(['name'=>'allocate_room', 'title' => 'Allocate Room']);
        

    }
}
