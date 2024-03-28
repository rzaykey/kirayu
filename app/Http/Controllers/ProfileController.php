<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Units;

class ProfileController extends Controller
{
    public function index()
    {
        return view('users.profile  ', [
            'user' => User::where('id', auth()->user()->id)->get(),
            'tittle' => 'Profile'
        ]);
    }

    public function show()
    {
        return view('users.profile  ', [
            'user' => User::where('id', auth()->user()->id)->get()
        ]);
    }

    public function edit($id)
    {
        return view('users.edit-profile  ', [
            'user' => User::where('id', auth()->user()->id)->get(),
            'roles' => Role::all(),
            'units' => Units::all()
        ]);
    }

    public function update(Request $request, User $user, $id)
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $rules = [
            'name' => 'max:255',
            'image' => 'image|file|max:1024',
            'email' => 'email',
            'unit_id' => 'max:255',
        ];

        $validatedData['updated_at'] = $updated_at;
        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] =  $request->file('image')->store('profile-images');
        }
        User::where('id', $id)
            ->update($validatedData);

        return view('users.profile  ', [
            'user' => User::where('id', auth()->user()->id)->get()
        ]);
    }
}