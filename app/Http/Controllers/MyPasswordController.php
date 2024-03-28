<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class MyPasswordController extends Controller
{
    public function index()
    {
        return view('users.password  ', [
            'user' => User::where('id', auth()->user()->id)->get()
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->user()->update([
            'password' => Hash::make($request->get('password'))
        ]);
        return view('users.profile  ', [
            'user' => User::where('id', auth()->user()->id)->get()
        ])->with('success', 'Berhasil mengubah data user.');
    }
}