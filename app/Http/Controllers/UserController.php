<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Units;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('is_admin');
        $roles = Role::all();
        if ($request->ajax()) {
            $data = User::with('role')->select('users.*');
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('roles_id'))) {
                        $instance->where('role_id', $request->get('roles_id'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('username', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('roles', function (User $user) {
                    return $user->role->role_name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/users/' . $row->id . '/edit/" class="btn btn-info btn-sm"> View </a>';
                    $btn = $btn . ' ' . '<a href="/password/' . $row->id . '/edit" class="btn btn-sm btn-warning">Edit Password</a>';
                    $btn  = $btn . ' ' . ' <form action="/users/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';

                    return $btn;
                })
                ->toJson();
        }

        return view('users.index', compact('roles'));
    }

    public function create()
    {

        return view('users.create', [
            'roles' => Role::all()
        ]);
    }

    public function store(Request $request)
    {

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:users',
            'username' => 'required|max:255|unique:users|without_spaces',
            'email' => 'required|email:dns|unique:users',
            'image' => 'image|file|max:1024',
            'password' => 'required|min:5|max:255',
            'role_id' => 'required',
            'remember_token'  => 'required'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] =  $request->file('image')->store('profile-images');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);
        return redirect('/users')->with('success', 'Berhasil menambahkan user.');
    }

    public function show(User $user)
    {

        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, User $user)
    {

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $rules = [
            'name' => 'max:255',
            'image' => 'image|file|max:1024',
            'email' => 'email',
            'password' => 'min:5|max:255',
            'role_id' => 'max:255'
        ];

        if ($request->username != $user->username) {
            $rules['username'] = 'max:255|unique:users|without_spaces';
        }

        $validatedData['updated_at'] = $updated_at;
        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] =  $request->file('image')->store('profile-images');
        }

        User::where('id', $user->id)
            ->update($validatedData);

        return redirect('/users')->with('success', 'Berhasil mengubah data user.');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->user()->id) {
            return redirect('/users')->with('success', 'Gagal menghapus user !');
        } else {
            if ($user->image) {
                Storage::delete($user->image);
            }
            User::destroy($user->id);
            return redirect('/users')->with('success', 'Berhasil menghapus user !');
        }
    }
}
