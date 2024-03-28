<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('*')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/categories/' . $row->id . '/edit/" class="btn btn-info btn-sm"> View </a>';
                    $btn  = $btn . ' ' . ' <form action="/categories/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('categories.index');
    }

    public function create()
    {

        return view('categories.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:categories',
        ]);

        Category::create($validatedData);
        return redirect('/categories')->with('success', 'Berhasil menambahkan Kategori.');
    }

    public function edit(Category $categories, $id)
    {
        $categories = Category::find($id);
        return view('categories.edit', [
            'categories' => $categories,
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

        Category::where('id', $id)
            ->update($validatedData);

        return redirect('/categories')->with('success', 'Berhasil mengubah data kategori.');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect('/categories')->with('success', 'Berhasil menghapus data kategori.');
    }
}