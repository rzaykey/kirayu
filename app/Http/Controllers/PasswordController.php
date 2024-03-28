<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.user-password', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $updated_at = \Carbon\Carbon::now()->toDateTimeString();

        $validatedData = $request->validate([
            'password' => 'required|min:5|max:255'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $validatedData['updated_at'] = $updated_at;

        User::where('id', $id)
            ->update($validatedData);

        return redirect('/users')->with('success', 'Berhasil mengubah password.');
    }
}