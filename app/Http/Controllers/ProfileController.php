<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Resident;

class ProfileController extends Controller
{

    public function view(): View
    {
        $user = auth()->user();
        return view('profile.view', $user);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $user = auth()->user();
        $validated = $request->validated();
        // dd($request->all());
        // $request->user()->fill($request->validated());

        $user->username = $validated['profile_name'];
        $user->user_id = $validated['profile_id'];

        $newImagePath = null;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images', $imageName, 'public');
            // $image->move(public_path('images'), $imageName);
            $newImagePath = 'images/' . $imageName;
            $user->image = 'images/' . $imageName;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user->save();

        $resident = Resident::where('user_id', $user->id)->first();
        if($resident && $newImagePath){
            $resident->image = $newImagePath;
            $resident->save();
        }
        
        $notification = array(
            'message' => 'Profile updated successfully',
            'alert-type' => 'success'
        );

        // $request->user()->save();
        
        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
        return redirect()->route('dashboard')->with($notification);
    }

    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     // if (!auth()->check()) {
    //     // dd('User is not authenticated');
    //     // }

    //     // dd($request->all(), auth()->user());

        
    //     $user = auth()->user();
    //     dd(get_class($user));
    //     $validated = $request->all();

    //     $user->username = $validated['profile_name'];
    //     $user->user_id = $validated['profile_id'];

    //     if ($user->isDirty('email')) {
    //         $user->email_verified_at = null;
    //     }

    //     $user->save();

    //     $notification = [
    //         'message' => 'Profile updated successfully',
    //         'alert-type' => 'success'
    //     ];

    //     return redirect()->route('dashboard')->with($notification);
    // }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
