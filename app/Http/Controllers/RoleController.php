<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::select('*')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/roles/' . $row->id . '/edit/" class="btn btn-info btn-sm"> View </a>';
                    $btn  = $btn . ' ' . ' <form action="/roles/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('roles.index');
    }

    public function create()
    {

        return view('roles.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'role_name' => 'required|max:255|unique:roles',
        ]);

        Role::create($validatedData);
        return redirect('/roles')->with('success', 'Berhasil menambahkan Role.');
    }

    public function edit(Role $role)
    {

        return view('roles.edit', [
            'role' => $role,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $rules = [
            'role_name' => 'max:255'
        ];

        $validatedData['updated_at'] = $updated_at;
        $validatedData = $request->validate($rules);

        Role::where('id', $role->id)
            ->update($validatedData);

        return redirect('/roles')->with('success', 'Berhasil mengubah data role.');
    }

    public function destroy(Role $role)
    {

        if ($role->id == auth()->user()->role_id = 1) {
            return redirect('/roles')->with('success', 'Gagal menghapus role !');
        } else {
            Role::destroy($role->id);
            return redirect('/roles')->with('success', 'Berhasil menghapus role !');
        }
    }
}