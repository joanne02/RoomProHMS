<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Ability;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('user_access.main_user_access', compact('roles'));
    }

    public function create()
    {
        return view('user_access.add_user_access');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_role_name' => 'required|unique:roles,name'
        ]);

        // Create role
        $role = Bouncer::role()->create([
            'name' => $request->user_role_name,
            'title' => ucfirst($request->user_role_name)
        ]);

        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
            if ($user) {
                Bouncer::assign($role)->to($user);
            }
        }

        return redirect()->route('adminroles.index');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $abilities = Ability::all();

        // Fetch ability names assigned to the role
        $assignedAbilityNames = DB::table('permissions')
            ->join('abilities', 'permissions.ability_id', '=', 'abilities.id')
            ->where('permissions.entity_id', $role->id)
            ->where('permissions.entity_type', 'roles')
            ->pluck('abilities.name')
            ->toArray();

        return view('user_access.edit_user_access', compact('role', 'abilities', 'assignedAbilityNames'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $abilities = $request->input('abilities', []);
        $assignedEntityIds = $request->input('assigned_entities', []); // expects array of user IDs

        // Step 1: Remove existing permissions
        DB::table('permissions')
            ->where('entity_id', $role->id)
            ->where('entity_type', 'roles')
            ->delete();

        // Step 2: Reassign abilities to role
        foreach ($abilities as $abilityName) {
            $ability = Ability::where('name', $abilityName)->first();

            if ($ability) {
                DB::table('permissions')->insert([
                    'ability_id'   => $ability->id,
                    'entity_id'    => $role->id,
                    'entity_type'  => 'roles',
                    'forbidden'    => 0,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        User::whereHas('roles', function ($query) use ($role) {
            $query->where('roles.id', $role->id);
        })->get()->each(function ($user) use ($role) {
            Bouncer::retract($role)->from($user);
        });

        // Step 3: Remove existing role assignments
        DB::table('assigned_roles')
            ->where('role_id', $role->id)
            ->delete();

        // Step 4: Assign role to new entities
        foreach ($assignedEntityIds as $entityId) {
            $user = User::find($entityId);
            if ($user) {
                Bouncer::assign($role)->to($user);
                Bouncer::refreshFor($user);
            }

        }

        $notification = [
            'message' => 'Role permissions and assignments updated successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->route('adminroles.index')->with($notification);
    }

}
