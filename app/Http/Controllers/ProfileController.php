<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(User $user)
    {
        return view('pages.profile.edit', [
            'user' => $user
        ]);
    }

    public function update(User $user, Request $request){
        $validated = $request->validate([
            'name' => ['unique:users,name,' . $user->id, 'max:10'],
            'password' => ['nullable', 'confirmed', Password::min(8)->mixedCase()->symbols()],
            'availabilities' => ['required','min:1']
        ]);

        $availabilities = [];

        foreach(json_decode($user->availability) as $availability){
            if(isset($validated['availabilities'][$availability->day])){
                $availabilities[] = ['day' => $availability->day, 'available' => true];
            }else{
                $availabilities[] = ['day' => $availability->day, 'available' => false];
            }
        }

        $validated['availability'] = json_encode($availabilities);

        if($validated['password'] === null){
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('dashboard')->with('success', __('Your profile has been saved'));
    }

    public function ajaxUpdateProfilePicture(User $user, Request $request){
        $user->saveProfilePicture($request->image);

        return;
    }
}
