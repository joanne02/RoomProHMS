<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mainUser(){
        $users = User::all();
        return view('user.main_user', compact('users'));
    }

    public function addUser(){
        return view('user.add_user');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'user_name'     => 'required|string',
            'user_email'    => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[\w\.-]+@unimas\.my$/'
            ],
            'user_type'     => 'required|string',
            'user_status'   => 'required|string',
            'user_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/'
            ],
            'user_id'       => 'required|string',
        ]);

        User::create([
            'username'             => $validated['user_name'],
            'email'                => $validated['user_email'],
            'usertype'             => $validated['user_type'],     // assuming your DB column is 'usertype'
            'status'               => $validated['user_status'],   // assuming your DB column is 'status'
            'password'             => Hash::make($validated['user_password']),
            'must_change_password' => true,
            'created_by_admin'     => true,
            'user_id'              => $validated['user_id'],       // assuming you store it in 'user_id' column
        ]);

        $notification = array(
            'message' => 'User created.',
            'alert-type' => 'success'
        );

        return redirect()->route('mainuser')->with($notification);
    }

    public function changeFirstPassword()
    {
        return view('auth.force-change-password');
    }

    public function updateFirstPassword(Request $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user(); 

        
        // Validate the new password
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed', // Ensure password confirmation
        ]);
        
        // // Hash the password before saving it
        $user->password = Hash::make($validated['password']);  // Make sure to hash the password
        $user->must_change_password = false; // Set must_change_password to false after the change

        $user->save(); // Save the updated user model
    
        // Regenerate the session to avoid session fixation
        $request->session()->regenerate();
    
        // Redirect to dashboard with success message
        return redirect()->route('dashboard')->with(['success', 'Password changed successfully.']);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'user_name'     => 'required|string',
            'user_email'    => 'required|email|unique:users,email,' . $id,
            'user_type'     => 'required|string',
            'user_status'   => 'required|string',
            // 'user_password' => 'nullable|string|min:8', // Make password optional
        ]);

        $user_id = $request->input('user_id');

        $user = User::findOrFail($id);
        $user->username = $validated['user_name'];
        $user->email = $validated['user_email'];
        $user->usertype = $validated['user_type'];
        $user->status = $validated['user_status'];
        $user->user_id = $user_id; // Assuming you want to update this too

        $user->save();

        $notification = array(
            'message' => 'Account updated.',
            'alert-type' => 'success'
        );

        return redirect()->route('mainuser')->with($notification);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('mainuser')->with(['success', 'Account deleted.']);
    }

}
