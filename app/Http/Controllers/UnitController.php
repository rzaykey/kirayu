<?php

namespace App\Http\Controllers;

use App\Models\Units;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Units::select('*')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/units/' . $row->id . '/edit/" class="btn btn-info btn-sm"> View </a>';
                    $btn  = $btn . ' ' . ' <form action="/units/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('units.index');
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:units',
        ]);

        Units::create($validatedData);
        return redirect('/units')->with('success', 'Berhasil menambahkan Unit.');
    }

    public function edit($id)
    {
        $units = Units::find($id);
        return view('units.edit', [
            'units' => $units,
        ]);
    }

    public function update(Request $request, $id)
    {
        $updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $rules = [
            'name' => 'max:255'
        ];

        $validatedData['updated_at'] = $updated_at;
        $validatedData = $request->validate($rules);

        Units::where('id', $id)
            ->update($validatedData);

        return redirect('/units')->with('success', 'Berhasil mengubah data role.');
    }

    public function destroy($id)
    {
        Units::destroy($id);
        return redirect('/units')->with('success', 'Berhasi menghapus unit.');
    }
}